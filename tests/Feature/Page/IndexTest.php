<?php

namespace Tests\Feature\Page;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{

    public function test_visit()
    {
        $this->get('/')->assertStatus(200);
    }
}
