<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testDependency()
    {
        // $foo = new Foo();
        $foo1 = $this->app->make(Foo::class); //new Foo()
        $foo2 = $this->app->make(Foo::class);

        self::assertEquals("Foo", $foo1->foo());
        self::assertEquals("Foo", $foo2->foo());
        self::assertNotSame($foo1, $foo2);
    }

    public function testBind()
    {
/*         $person = $this->app->make(Person::class);
        self::assertNotNull($person);
 */
        $this->app->bind(Person::class, function () {
            return new Person("M", "S");
        });

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertEquals("M", $person1->firstname); // closure() // new Person("M", "S")
        self::assertEquals("M", $person2->firstname); // closure() // new Person("M", "S")
        self::assertNotSame($person1, $person2);
        
    }

    public function testSingleton()
    {
        $this->app->singleton(Person::class, function () {
            return new Person("M", "S");
        });

        $person1 = $this->app->make(Person::class); // new Person("M", "S"); if not exists
        $person2 = $this->app->make(Person::class); // return existing
        $person3 = $this->app->make(Person::class); // return existing
        $person4 = $this->app->make(Person::class); // return existing

        self::assertEquals("M", $person1->firstname);
        self::assertEquals("M", $person2->firstname);
        self::assertEquals("M", $person3->firstname);
        self::assertEquals("M", $person4->firstname);
        self::assertSame($person1, $person2);
        self::assertSame($person2, $person3);
        self::assertSame($person3, $person4);
    }

    public function testInstance()
    {
        $person = new Person("M","S");
        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class); // $person
        $person2 = $this->app->make(Person::class); // $person
        $person3 = $this->app->make(Person::class); // $person
        $person4 = $this->app->make(Person::class); // $person

        self::assertEquals("M", $person1->firstname);
        self::assertEquals("M", $person2->firstname);
        self::assertEquals("M", $person3->firstname);
        self::assertEquals("M", $person4->firstname);
        self::assertSame($person1, $person2);
        self::assertSame($person2, $person3);
        self::assertSame($person3, $person4);
    }

    public function testDependencyInjection()
    {
        $this->app->singleton(Foo::class, function () {
            return new Foo();
        });
        $this->app->singleton(Bar::class, function ($app) {
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });

        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($foo, $bar1->foo);
        self::assertSame($bar1, $bar2);
    }

    public function testInterfaceToClass()
    {
        // $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);
        $this->app->singleton(HelloService::class, function ($app) {
            return new HelloServiceIndonesia();
        });

        $helloService = $this->app->make(HelloService::class);
        
        self::assertEquals('Halo M', $helloService->hello('M'));
    }
}
