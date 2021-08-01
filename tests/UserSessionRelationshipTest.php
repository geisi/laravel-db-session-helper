<?php

namespace Geisi\LaravelDbSessionHelper\Tests;

use Geisi\LaravelDbSessionHelper\Models\Session;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class UserSessionRelationshipTest extends TestCase
{
    public function test_relation_can_be_accessed()
    {
        $this->assertTrue($this->testUser->session instanceof \Geisi\LaravelDbSessionHelper\Contracts\Session);
    }

    public function test_relation_exists()
    {
        $this->assertTrue($this->testUser->session() instanceof HasOne);
    }

    public function test_newest_session_model_is_returned_if_multiple_session_entries_exist()
    {
        $beforeRecentlyLoggedInDate = $this->recentlyLoggedInDate->copy()->subMinutes(5);

        $this->testSession = Session::forceCreate([
            'id' => Str::uuid(),
            'user_id' => $this->testUser->id,
            'last_activity' => $beforeRecentlyLoggedInDate,
        ]);
        $this->assertTrue($this->testUser->fresh()->session->last_activity->equalTo($this->recentlyLoggedInDate));

        $this->testSession = Session::forceCreate([
            'id' => Str::uuid(),
            'user_id' => $this->testUser->id,
            'last_activity' => $beforeRecentlyLoggedInDate->addMinutes(20),
        ]);

        $this->assertTrue($this->testUser->fresh()->session->last_activity->equalTo($beforeRecentlyLoggedInDate));
    }
}
