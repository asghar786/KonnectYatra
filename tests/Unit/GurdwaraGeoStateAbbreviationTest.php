<?php

namespace Tests\Unit;

use App\Support\GurdwaraGeo;
use Tests\TestCase;

class GurdwaraGeoStateAbbreviationTest extends TestCase
{
    public function test_plain_state_name()
    {
        $this->assertSame('FL', GurdwaraGeo::stateAbbreviation('Florida'));
        $this->assertSame('PA', GurdwaraGeo::stateAbbreviation('Pennsylvania'));
    }

    public function test_a_departure_origins_style_label_with_a_parenthetical()
    {
        $this->assertSame('NY', GurdwaraGeo::stateAbbreviation('New York (NY · NJ · CT)'));
        $this->assertSame('IL', GurdwaraGeo::stateAbbreviation('Illinois (IN · OH)'));
    }

    public function test_washington_dc_special_case()
    {
        $this->assertSame('DC', GurdwaraGeo::stateAbbreviation('Washington DC (DE · MD · VA)'));
        $this->assertSame('DC', GurdwaraGeo::stateAbbreviation('Washington DC'));
    }

    public function test_unrecognised_label_falls_back_to_itself_rather_than_disappearing()
    {
        $this->assertSame('Some Made Up Place', GurdwaraGeo::stateAbbreviation('Some Made Up Place'));
    }

    public function test_empty_input()
    {
        $this->assertSame('', GurdwaraGeo::stateAbbreviation(''));
        $this->assertSame('', GurdwaraGeo::stateAbbreviation(null));
    }
}
