<?php

namespace Tests\Feature\Site;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomepageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function homepage_is_okay()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
