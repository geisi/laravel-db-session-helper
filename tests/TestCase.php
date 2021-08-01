<?php

namespace Geisi\LaravelDbSessionHelper\Tests;

use Geisi\LaravelDbSessionHelper\LaravelDbSessionHelperServiceProvider;
use Geisi\LaravelDbSessionHelper\Models\Session;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
        $this->testUser = User::create(['email' => 'test@user.com']);

        $this->recentlyLoggedInDate = now()->subMinutes(5)->milliseconds(0);
        $this->pastLoggedInDate = now()->subMinutes(50)->milliseconds(0);

        $this->testSession = Session::forceCreate([
            'id' => Str::uuid(),
            'user_id' => $this->testUser->id,
            'last_activity' => $this->recentlyLoggedInDate,
        ]);

        $this->testNotOnlineUser = User::forceCreate(['email' => 'second@test.de']);
        $this->testNeverLoggedInUser = User::forceCreate(['email' => 'third@test.de']);

        Session::forceCreate([
            'id' => Str::uuid(),
            'user_id' => $this->testNotOnlineUser->id,
            'last_activity' => $this->pastLoggedInDate,
        ]);
    }

    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->softDeletes();
        });

        $app['db']->connection()->getSchemaBuilder()->create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->integer('last_activity')->index();
        });
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ]);

        // Use test User model for users provider
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('db-session-helper.login_time_span', 10);

        /*
        include_once __DIR__.'/../database/migrations/create_laravel-db-session-helper_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelDbSessionHelperServiceProvider::class,
        ];
    }
}
