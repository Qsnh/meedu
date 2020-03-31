<?php


namespace Tests\Feature\BackendApi;

use App\Models\Administrator;

class AdministratorTest extends Base
{

    public const MODEL = Administrator::class;

    public const MODEL_NAME = 'administrator';

    public const FILL_DATA = [
        'name' => '我是管理员',
        'email' => 'meedu@meedu.vip',
        'password' => '123123',
        'password_confirmation' => '123123',
    ];

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
        $response = $this->user($this->admin)->get(self::API_V1_PREFIX . '/' . self::MODEL_NAME);
        $this->assertResponseSuccess($response);
    }

    public function test_create()
    {
        $response = $this->user($this->admin)->post(self::API_V1_PREFIX . '/' . self::MODEL_NAME, self::FILL_DATA);
        $this->assertResponseSuccess($response);
    }

    public function test_edit()
    {
        $item = factory(self::MODEL)->create();
        $response = $this->user($this->admin)->get(self::API_V1_PREFIX . '/' . self::MODEL_NAME . '/' . $item->id);
        $this->assertResponseSuccess($response);
    }

    public function test_update()
    {
        $item = factory(self::MODEL)->create();
        $response = $this->user($this->admin)->put(self::API_V1_PREFIX . '/' . self::MODEL_NAME . '/' . $item->id, self::FILL_DATA);
        $this->assertResponseSuccess($response);
    }

    public function test_destroy()
    {
        $item = factory(self::MODEL)->create();
        $response = $this->user($this->admin)->delete(self::API_V1_PREFIX . '/' . self::MODEL_NAME . '/' . $item->id);
        // 超管无法删除
        $this->assertResponseError($response);
    }

}