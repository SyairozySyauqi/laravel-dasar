<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testGet()
    {
        $this->get('/test')
            ->assertStatus(200)
            ->assertSeeText('Test');
    }

    public function testRedirect()
    {
        $this->get('/youtube')
            ->assertRedirect('/test');
    }

    public function testFallback()
    {
        $this->get('/testo')
            ->assertSeeText('404');
        $this->get('/tesuto')
            ->assertSeeText('404');
        $this->get('/testop')
            ->assertSeeText('404');
    }

    public function testRouteParameter()
    {
        $this->get('/products/1')
            ->assertSeeText('Product 1');
        $this->get('/products/2/items/3')
            ->assertSeeText('Product 2, Item 3');
    } 

    public function testRouteParameterRegex()
    {
        $this->get('/categories/1')
            ->assertSeeText('Category 1');
        $this->get('category/i')
            ->assertSeeText('404');    
    }

    public function testRouteParameterOptional()
    {
        $this->get('/users/M')
            ->assertSeeText('User M');
        $this->get('/users/')
            ->assertSeeText('User 404');    
    }

    public function testRouteConflict()
    {
        $this->get('/conflict/test')
            ->assertSeeText('Conflict test');
        $this->get('/conflict/m')
            ->assertSeeText('Conflict M S S');    
    }

    public function testNamedRoute()
    {
        $this->get('/produk/12345')
            ->assertSeeText('Link http://localhost/products/12345');
        $this->get('/produk-redirect/12345')
            ->assertSeeText('/products/12345');
    }
}
