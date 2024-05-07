<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class URLGenerationTest extends TestCase
{
    public function testURLCurrent()
    {
        $this->get('/url/current?name=MSS')->assertSeeText('/url/current?name=MSS');
    }

    public function testNamed()
    {
        $this->get('/redirect/named')->assertSeeText('MSS');
    }
}
