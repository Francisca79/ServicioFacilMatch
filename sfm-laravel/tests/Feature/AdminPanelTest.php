<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_clientes_section(): void
    {
        $admin = User::factory()->create(['tipo_usuario' => 'admin']);
        User::factory()->create(['tipo_usuario' => 'cliente']);

        $this->actingAs($admin)->get('/panel/admin/clientes')->assertOk();
    }

    public function test_admin_can_view_reportes(): void
    {
        $admin = User::factory()->create(['tipo_usuario' => 'admin']);

        $this->actingAs($admin)->get('/panel/admin/reportes')->assertOk();
    }

    public function test_admin_can_toggle_cliente_bloqueo(): void
    {
        $admin = User::factory()->create(['tipo_usuario' => 'admin']);
        $cliente = User::factory()->create(['tipo_usuario' => 'cliente', 'bloqueado' => false]);

        $this->actingAs($admin)
            ->post("/panel/admin/clientes/{$cliente->id}/bloqueo")
            ->assertRedirect();

        $this->assertTrue($cliente->fresh()->bloqueado);
    }
}
