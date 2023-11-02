<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApiTest extends TestCase
{
    /**  
     * @test 
     * 
     * Checks if tag param error is working
     * */
    public function tagParamError(): void
    {
        $response = $this->get('/api/get');
        $response->assertJson([
            'error' => true,
            'errorCode' => 20
        ]);
    }

    /**  
     * @test 
     * 
     * Checks if dateFrom format error is working
     * */
    public function dateFromFormatError(): void
    {
        $response = $this->get('/api/get/test_tag/202s3-01-01');
        $response->assertJson([
            'error' => true,
            'errorCode' => 21
        ]);
    }

    /**  
     * @test 
     * 
     * Checks if dateTo format error is working
     * */
    public function dateToFormatError(): void
    {
        $response = $this->get('/api/get/test_tag/2023-01-01/2023-15-01');
        $response->assertJson([
            'error' => true,
            'errorCode' => 21
        ]);
    }

    /**  
     * @test 
     * 
     * Checks if dateFrom > dateTo error is working
     * */
    public function dateFromGtDateTo(): void
    {
        $response = $this->get('/api/get/test_tag/2023-01-02/2023-01-01');
        $response->assertJson([
            'error' => true,
            'errorCode' => 22
        ]);
    }

}
