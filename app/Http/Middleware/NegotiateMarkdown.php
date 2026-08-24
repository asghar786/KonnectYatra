<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use League\HTMLToMarkdown\HtmlConverter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Markdown content negotiation — https://acceptmarkdown.com
 *
 * An agent that sends `Accept: text/markdown` gets the same page back as a
 * compact Markdown document instead of the full HTML/CSS/JS bundle, at the
 * same canonical URL. Browsers are unaffected: they don't send that header,
 * so they always get the normal HTML unchanged.
 *
 * Per the spec: honour q-values, respond
 * `Content-Type: text/markdown; charset=utf-8`, mark every negotiable
 * response `Vary: Accept` (so a shared cache never serves the HTML variant
 * to an agent, or the Markdown variant to a browser, depending on which one
 * happened to be cached first), and return 406 when the client accepts
 * neither representation.
 */
class NegotiateMarkdown
{
    /** Path prefixes with nothing an agent needs, or gated behind a login. */
    private const SKIP_PREFIXES = [
        'admin', 'admin_login', 'admin_logout',
        'user', 'login', 'register', 'logout',
    ];

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!$this->applies($request, $response)) {
            return $response;
        }

        // Every response from a negotiable route must carry this, whichever
        // representation it happens to be — that's what lets a shared cache
        // store the HTML and Markdown variants separately instead of
        // serving whichever one landed in cache first to everybody.
        $response->headers->set('Vary', $this->mergeVary($response->headers->get('Vary')));

        $preference = $this->negotiate($request->header('Accept'));

        if ($preference === 'none') {
            return response(
                "This page is available as text/html or text/markdown.\n",
                406,
                ['Content-Type' => 'text/plain; charset=utf-8', 'Vary' => 'Accept']
            );
        }

        if ($preference === 'markdown') {
            return $this->toMarkdown($response);
        }

        return $response;
    }

    private function applies(Request $request, $response): bool
    {
        if (!$request->isMethod('GET') && !$request->isMethod('HEAD')) {
            return false;
        }

        if (!$response instanceof Response) {
            return false;
        }

        $status = $response->getStatusCode();
        if ($status < 200 || $status >= 300) {
            return false;
        }

        $contentType = (string) $response->headers->get('Content-Type');
        if (stripos($contentType, 'text/html') === false) {
            return false;
        }

        $segment = strtolower(explode('/', trim($request->path(), '/'))[0] ?? '');

        return !in_array($segment, self::SKIP_PREFIXES, true);
    }

    private function mergeVary(?string $existing): string
    {
        $values = array_filter(array_map('trim', explode(',', (string) $existing)));

        if (!in_array('Accept', $values, true)) {
            $values[] = 'Accept';
        }

        return implode(', ', $values);
    }

    /**
     * 'markdown', 'html' or 'none' — honouring q-values per RFC 9110.
     *
     * No Accept header at all means "accepts anything" (the common case for
     * a plain browser navigation), so that defaults to html rather than 406.
     */
    private function negotiate(?string $accept): string
    {
        if ($accept === null || trim($accept) === '') {
            return 'html';
        }

        $parsed = $this->parseAccept($accept);

        $qHtml = $this->qFor($parsed, 'text/html');
        $qMarkdown = $this->qFor($parsed, 'text/markdown');

        if ($qHtml <= 0.0 && $qMarkdown <= 0.0) {
            return 'none';
        }

        return $qMarkdown > $qHtml ? 'markdown' : 'html';
    }

    /** @return array<string,float> media type => q-value */
    private function parseAccept(string $accept): array
    {
        $out = [];

        foreach (explode(',', $accept) as $part) {
            $pieces = explode(';', trim($part));
            $type = strtolower(trim(array_shift($pieces)));

            if ($type === '') {
                continue;
            }

            $q = 1.0;
            foreach ($pieces as $param) {
                if (preg_match('/^\s*q\s*=\s*([0-9.]+)/i', $param, $m)) {
                    $q = (float) $m[1];
                }
            }

            $out[$type] = $q;
        }

        return $out;
    }

    /** Most specific match wins: exact type, then type/*, then *\/*. */
    private function qFor(array $parsed, string $type): float
    {
        if (array_key_exists($type, $parsed)) {
            return $parsed[$type];
        }

        [$main] = explode('/', $type, 2);

        if (array_key_exists($main . '/*', $parsed)) {
            return $parsed[$main . '/*'];
        }

        if (array_key_exists('*/*', $parsed)) {
            return $parsed['*/*'];
        }

        return 0.0;
    }

    private function toMarkdown(Response $response): Response
    {
        $markdown = $this->extractMarkdown((string) $response->getContent());

        $converted = response($markdown, $response->getStatusCode());
        $converted->headers->replace($response->headers->all());
        $converted->headers->set('Content-Type', 'text/markdown; charset=utf-8');
        $converted->headers->remove('Content-Length');

        return $converted;
    }

    /**
     * Reduce a rendered page down to its title, description and main
     * content, converted to Markdown — a "cleaner, more token-efficient
     * view of the same content" (AgentReady AR-CONT-02) rather than a
     * markdown dump of the full nav/footer/script chrome around it.
     */
    private function extractMarkdown(string $html): string
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);

        $title = trim($xpath->evaluate('string(//title)'));
        $description = trim($xpath->evaluate('string(//meta[@name="description"]/@content)'));
        $canonical = trim($xpath->evaluate('string(//link[@rel="canonical"]/@href)'));

        $main = $xpath->query('//*[@id="content"]')->item(0) ?? $xpath->query('//body')->item(0);

        if ($main) {
            foreach (['script', 'style', 'noscript', 'svg', 'iframe'] as $tag) {
                foreach (iterator_to_array($main->getElementsByTagName($tag)) as $node) {
                    $node->parentNode->removeChild($node);
                }
            }
        }

        $fragmentHtml = $main ? $dom->saveHTML($main) : $html;

        $converter = new HtmlConverter(['strip_tags' => true, 'hard_break' => false]);
        $body = trim($converter->convert($fragmentHtml ?: ''));
        $body = preg_replace("/\n{3,}/", "\n\n", $body);

        $lines = [];

        if ($title !== '') {
            $lines[] = '# ' . $title;
            $lines[] = '';
        }

        if ($description !== '') {
            $lines[] = '> ' . $description;
            $lines[] = '';
        }

        $lines[] = $body;

        if ($canonical !== '') {
            $lines[] = '';
            $lines[] = '---';
            $lines[] = 'Source: ' . $canonical;
        }

        return implode("\n", $lines) . "\n";
    }
}
