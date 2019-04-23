<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Models\User;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        factory('App\Post', 2)->create();
        $this->assertTrue(true);
    }

    public function testTrue(){
        $this->assertTrue(true);
    }


    public function testTakeAName(){

        $user =new User;

        $user->setName('Bangladesh');

        $this->assertEquals($user->getName(),'Bangladesh');

    }



}
