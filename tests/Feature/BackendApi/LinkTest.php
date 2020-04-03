<?php


namespace Tests\Feature\BackendApi;


use App\Models\Administrator;
use App\Services\Other\Models\Link;

class LinkTest extends Base
{

    protected $admin;

    public function setUp()
    {
        parent::setUp();
        $this->admin = factory(Administrator::class)->create();
    }

    public function tearDown()
    {
        $this->admin->delete();
        parent::tearDown();
    }

    public function test_index()
    {
        $response = $this->user($this->admin)->get(self::API_V1_PREFIX . '/link');
        $data = $this->assertResponseSuccess($response);
    }

    public function test_create()
    {
        $response = $this->user($this->admin)->post(self::API_V1_PREFIX . '/link', [
            'sort' => 1,
            'name' => 'meedu',
            'url' => 'http://meedu.vip',
        ]);
        $data = $this->assertResponseSuccess($response);
    }

    public function test_edit()
    {
        $link = factory(Link::class)->create();
        $response = $this->user($this->admin)->get(self::API_V1_PREFIX . '/link/' . $link->id);
        $data = $this->assertResponseSuccess($response);
        $this->assertEquals($link->name, $data['data']['name']);
    }

    public function test_update()
    {
        $link = factory(Link::class)->create([
            'name' => 1,
            'url' => 2,
            'sort' => 3
        ]);
        $response = $this->user($this->admin)->put(self::API_V1_PREFIX . '/link/' . $link->id, [
            'sort' => 1,
            'name' => 'meedu',
            'url' => 'http://meedu.vip',
        ]);
        $data = $this->assertResponseSuccess($response);

        $link->refresh();
        $this->assertEquals(1, $link->sort);
        $this->assertEquals('meedu', $link->name);
        $this->assertEquals('http://meedu.vip', $link->url);
    }

    public function test_destroy()
    {
        $link = factory(Link::class)->create();
        $response = $this->user($this->admin)->delete(self::API_V1_PREFIX . '/link/' . $link->id);
        $data = $this->assertResponseSuccess($response);
        $this->assertEmpty(Link::find($link->id));
    }


}