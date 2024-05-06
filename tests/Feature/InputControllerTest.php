<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=M')->assertSeeText('Hello M');
        $this->post('/input/hello', [
            'name' => 'M',
        ])->assertSeeText('Hello M');
    }

    public function testNestedInput()
    {
        $this->post('/input/hello/first', [
            'name'=> [
                'first'=> 'M',
                'last'=> 'S',
            ],
        ])->assertSeeText('Hello M');
    }

    public function testInputAll()
    {
        $this->post('/input/hello/first', [
            'name'=> [
                'first'=> 'M',
                'last'=> 'S',
            ],
        ])->assertSeeText('name')->assertSeeText('M')->assertSeeText('last')->assertSeeText('S');
    }

    public function testArrayInput()
    {
        $this->post('/input/hello/array', [
            'products'=> [
                [
                    'name'=> 'Apple',
                    'price'=> 4000,
                ],
                [
                    'name'=> 'Pear',
                    'price'=> 5000,
                ]
            ],
        ])->assertSeeText('Apple')->assertSeeText('Pear');
    }

    public function testInputType()
    {
        $this->post('/input/type', [
            'name' => 'M',
            'married' => 'false',
            'birth_date' => '10-10-2010'
        ])->assertSeeText('M')->assertSeeText('false')->assertSeeText('2010');
    }
} 
