<?php

namespace Tests\Feature;

use Tests\TestCase;

class PrivacyPageTest extends TestCase
{
    public function test_privacy_page_loads_with_at_least_500_characters_of_content()
    {
        $response = $this->get('/privacy');

        $response->assertStatus(200);
        $response->assertSee('Privacy Policy');
        $response->assertSee(\App\Support\Business::email());

        $text = trim(preg_replace('/\s+/', ' ', strip_tags($response->getContent())));
        $this->assertGreaterThanOrEqual(500, strlen($text));
    }

    public function test_footer_links_to_privacy_page()
    {
        $response = $this->get('/aboutus');

        $response->assertStatus(200);
        $response->assertSee(url('/privacy'), false);
    }

    public function test_sitemap_lists_the_privacy_page()
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertSee('<loc>' . url('privacy') . '</loc>', false);
    }
}
