<?php

namespace Geisi\LaravelDbSessionHelper\Tests;

use Geisi\LaravelDbSessionHelper\Models\Session;
use Illuminate\Support\Str;

class SessionModelTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->testSession = Session::forceCreate([
            'id' => Str::uuid(),
            'user_id' => $this->testUser->id,
            'last_activity' => $this->recentlyLoggedInDate,
        ]);
    }

    public function test_is_online_attribute_is_right()
    {
        $this->assertTrue($this->testUser->session->is_online);
        $this->assertFalse($this->testNotOnlineUser->session->is_online);
    }

    public function test_last_login_attribute_is_right()
    {
        $this->assertTrue($this->recentlyLoggedInDate->equalTo($this->testUser->session->last_login));
        $this->assertTrue($this->pastLoggedInDate->equalTo($this->testNotOnlineUser->session->last_login));
    }
}
