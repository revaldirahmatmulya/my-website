<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ArtisanRunnerTest extends TestCase
{
    public function test_artisan_endpoint_is_forbidden_without_key(): void
    {
        putenv('ARTISAN_KEY=my-super-secret-key');
        $_ENV['ARTISAN_KEY'] = 'my-super-secret-key';

        $response = $this->get('/artisan/migrate');

        $response->assertStatus(403);
    }

    public function test_artisan_endpoint_is_forbidden_with_wrong_key(): void
    {
        putenv('ARTISAN_KEY=my-super-secret-key');
        $_ENV['ARTISAN_KEY'] = 'my-super-secret-key';

        $response = $this->get('/artisan/migrate?key=wrong-key');

        $response->assertStatus(403);
    }

    public function test_artisan_endpoint_rejects_unauthorized_command(): void
    {
        putenv('ARTISAN_KEY=my-super-secret-key');
        $_ENV['ARTISAN_KEY'] = 'my-super-secret-key';

        $response = $this->get('/artisan/unauthorized-command?key=my-super-secret-key');

        $response->assertStatus(400);
    }

    public function test_artisan_endpoint_executes_allowed_command_with_valid_key(): void
    {
        putenv('ARTISAN_KEY=my-super-secret-key');
        $_ENV['ARTISAN_KEY'] = 'my-super-secret-key';

        $response = $this->get('/artisan/migrate-status?key=my-super-secret-key');

        $response->assertOk();
        $response->assertSee('=== Artisan migrate:status ===');
    }

    public function test_artisan_endpoint_supports_mongodb_test_command(): void
    {
        putenv('ARTISAN_KEY=my-super-secret-key');
        $_ENV['ARTISAN_KEY'] = 'my-super-secret-key';

        $response = $this->get('/artisan/mongodb-test?key=my-super-secret-key');

        $response->assertOk();
        $response->assertSee('=== Artisan mongodb:test ===');
    }
}
