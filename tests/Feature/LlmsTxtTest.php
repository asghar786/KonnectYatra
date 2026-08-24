<?php

namespace Tests\Feature;

use Tests\TestCase;

class LlmsTxtTest extends TestCase
{
    public function test_llms_txt_is_served_with_when_to_use_guidance()
    {
        $response = $this->get('/llms.txt');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=utf-8');

        $body = $response->getContent();
        $this->assertStringContainsString('# Konnect Yatra', $body);
        $this->assertStringContainsString('## When to use this', $body);
        $this->assertStringContainsString('Sikh pilgrim', $body);
        $this->assertStringContainsString(url('all-packages'), $body);
        $this->assertStringContainsString(url('privacy'), $body);
        $this->assertStringContainsString(\App\Support\Business::email(), $body);
    }
}
