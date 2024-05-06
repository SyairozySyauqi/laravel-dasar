<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView()
    {
        $this->get('/hello')
            ->assertSeeText('Hello M');
        $this->get('/helloo')
            ->assertSeeText('Hello M');
    }
    
    public function testNested()
    {
        $this->get('/helloWorld')
            ->assertSeeText('Hello World');
    }

    public function testTemplate()
    {
        $this->view('hello', ['name' => 'M'])
            ->assertSeeText('Hello M');
        $this->view('hello.world')
            ->assertSeeText('Hello World');
    }
}
