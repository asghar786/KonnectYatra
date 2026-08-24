<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Markdown content negotiation (acceptmarkdown.com) — App\Http\Middleware\NegotiateMarkdown.
 */
class MarkdownNegotiationTest extends TestCase
{
    public function test_default_request_still_gets_html()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/html; charset=UTF-8');
        $this->assertStringContainsString('Accept', $response->headers->get('Vary'));
    }

    public function test_wildcard_accept_still_gets_html()
    {
        // curl's default Accept: */* — must not flip existing tooling over to markdown.
        $response = $this->get('/', ['Accept' => '*/*']);

        $response->assertStatus(200);
        $this->assertStringContainsStringIgnoringCase('text/html', $response->headers->get('Content-Type'));
    }

    public function test_accept_text_markdown_returns_markdown()
    {
        $response = $this->get('/', ['Accept' => 'text/markdown']);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/markdown; charset=utf-8');
        $this->assertStringContainsString('Accept', $response->headers->get('Vary'));

        $body = $response->getContent();
        $this->assertStringNotContainsString('<html', $body);
        $this->assertStringNotContainsString('<script', $body);
        $this->assertNotEmpty(trim($body));
    }

    public function test_q_values_are_honoured()
    {
        // HTML explicitly preferred over markdown.
        $response = $this->get('/', ['Accept' => 'text/markdown;q=0.4, text/html;q=0.9']);
        $this->assertStringContainsStringIgnoringCase('text/html', $response->headers->get('Content-Type'));

        // Markdown explicitly preferred over HTML.
        $response = $this->get('/', ['Accept' => 'text/markdown;q=0.9, text/html;q=0.4']);
        $response->assertHeader('Content-Type', 'text/markdown; charset=utf-8');
    }

    public function test_unacceptable_media_type_returns_406()
    {
        $response = $this->get('/', ['Accept' => 'application/json']);

        $response->assertStatus(406);
    }

    public function test_admin_login_page_is_not_negotiated()
    {
        $response = $this->get('/admin_login', ['Accept' => 'text/markdown']);

        $response->assertStatus(200);
        $this->assertStringContainsStringIgnoringCase('text/html', $response->headers->get('Content-Type'));
    }

    public function test_privacy_page_converts_to_markdown_with_source_link()
    {
        $response = $this->get('/privacy', ['Accept' => 'text/markdown']);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/markdown; charset=utf-8');

        $body = $response->getContent();
        $this->assertMatchesRegularExpression('/^# .*Privacy Policy/m', $body);
        // The exact canonical value is Schema::canonical()'s own concern (and, inside one
        // PHPUnit process, can carry an override set by an earlier request in the same run —
        // never happens in prod, where every request is a fresh PHP-FPM process). Here we only
        // need to confirm the middleware pulled the page's own <link rel="canonical"> through.
        $this->assertMatchesRegularExpression('/^Source: https?:\/\/\S+$/m', $body);
    }
}
