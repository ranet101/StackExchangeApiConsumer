<?php

namespace Tests\Feature;

use Tests\TestCase;

class AppTest extends TestCase
{
    /** 
     * @test 
     * 
     * App path must responds 400
     * */
    public function appResponds(): void
    {
        $response = $this->get('/');
        $response->assertStatus(400);
    }


    /** 
     * @test 
     * 
     * Api path must responds 404
     * */
    public function apiResponds(): void
    {
        $response = $this->get('/api');
        $response->assertStatus(404);
    }

}
