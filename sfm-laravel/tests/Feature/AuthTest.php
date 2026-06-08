<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_login_page_loads(): void
    {
        $this->get('/login')->assertOk();
    }

    public function test_admin_can_access_panel(): void
    {
        $admin = User::factory()->create(['tipo_usuario' => 'admin', 'email' => 'admin@test.com']);

        $this->actingAs($admin)->get('/panel/admin')->assertOk();
    }

    public function test_cliente_cannot_access_admin_panel(): void
    {
        $cliente = User::factory()->create(['tipo_usuario' => 'cliente']);

        $this->actingAs($cliente)->get('/panel/admin')->assertForbidden();
    }

    public function test_blocked_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'tipo_usuario' => 'cliente',
            'email' => 'bloqueado@test.com',
            'password' => bcrypt('123456'),
            'bloqueado' => true,
        ]);

        $this->post('/login', [
            'correo' => 'bloqueado@test.com',
            'contrasena' => '123456',
        ])->assertSessionHasErrors('correo');
    }
}
