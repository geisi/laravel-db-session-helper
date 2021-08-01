<?php

namespace Geisi\LaravelDbSessionHelper\Tests;

class HasDatabaseSessionsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_can_scope_logged_in_users()
    {
        $this->assertTrue(User::isOnline()->count() === 1);
    }

    public function test_it_can_scope_logged_out_users()
    {
        User::isOffline()->dump();
        $this->assertTrue(User::isOffline()->count() === 2);
    }

    public function test_is_online_attribute_is_right()
    {
        $this->assertTrue($this->testUser->is_online);
        $this->assertFalse($this->testNotOnlineUser->is_online);
        $this->assertFalse($this->testNeverLoggedInUser->is_online);
    }

    public function test_get_last_online_attribute_is_right()
    {
        $this->assertTrue($this->recentlyLoggedInDate->equalTo($this->testUser->last_login));
        $this->assertTrue($this->pastLoggedInDate->equalTo($this->testNotOnlineUser->last_login));
        $this->assertTrue($this->testNeverLoggedInUser->last_login === null);
    }
}
