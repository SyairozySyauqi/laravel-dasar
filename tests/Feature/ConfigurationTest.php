<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function test_example()
    {
        $firstname = config("contoh.author.first");
        $lastname = config("contoh.author.last");
        $email = config("contoh.email");
        $company = config("contoh.company");

        self::assertEquals("M", $firstname);
        self::assertEquals("S", $lastname);
        self::assertEquals("syairozys@gmail.com", $email);
        self::assertEquals("Zerone", $company);
    }
}
