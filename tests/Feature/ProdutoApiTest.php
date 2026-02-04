<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutoApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Criar dados de teste
        $usuario = User::factory()->create();
        $categoria = Categoria::create(['nome' => 'Eletrônicos']);
        
        Produto::create([
            'nome' => 'Produto Teste',
            'valor' => 100.00,
            'quantidade' => 5,
            'ativo' => true,
            'usuario_id' => $usuario->id,
            'categoria_id' => $categoria->id,
        ]);
    }

    public function test_pode_listar_produtos_ativos(): void
    {
        $response = $this->getJson('/api/produtos');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'nome', 'valor', 'quantidade', 'categoria', 'usuario']
                ]
            ]);
    }

    public function test_pode_listar_produtos_de_usuario(): void
    {
        $usuario = User::first();
        
        $response = $this->getJson("/api/usuarios/{$usuario->id}/produtos");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'usuario' => ['id', 'nome'],
                'produtos' => [
                    '*' => ['id', 'nome', 'valor', 'quantidade', 'categoria', 'usuario']
                ]
            ]);
    }

    public function test_pode_remover_quantidade_do_estoque(): void
    {
        $produto = Produto::first();
        
        $response = $this->patchJson("/api/produtos/{$produto->id}/remover", [
            'quantidade' => 2
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'produto' => ['id', 'nome', 'valor', 'quantidade']
            ]);

        $this->assertDatabaseHas('produtos', [
            'id' => $produto->id,
            'quantidade' => 3 // 5 - 2
        ]);
    }

    public function test_nao_pode_remover_quantidade_maior_que_estoque(): void
    {
        $produto = Produto::first();
        
        $response = $this->patchJson("/api/produtos/{$produto->id}/remover", [
            'quantidade' => 10
        ]);

        $response->assertStatus(422);
    }
}
