<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuario1 = User::where('email', 'usuario1@example.com')->first();
        $usuario2 = User::where('email', 'usuario2@example.com')->first();

        $eletronicos = Categoria::where('nome', 'Eletrônicos')->first();
        $alimentos = Categoria::where('nome', 'Alimentos')->first();
        $vestuario = Categoria::where('nome', 'Vestuário')->first();
        $livros = Categoria::where('nome', 'Livros')->first();
        $moveis = Categoria::where('nome', 'Móveis')->first();

        Produto::create([
            'nome' => 'Notebook Dell Inspiron',
            'valor' => 3500.00,
            'quantidade' => 5,
            'ativo' => true,
            'usuario_id' => $usuario1->id,
            'categoria_id' => $eletronicos->id,
        ]);

        Produto::create([
            'nome' => 'Mouse Logitech',
            'valor' => 89.90,
            'quantidade' => 0,
            'ativo' => false,
            'usuario_id' => $usuario1->id,
            'categoria_id' => $eletronicos->id,
        ]);

        Produto::create([
            'nome' => 'Livro Clean Code',
            'valor' => 75.00,
            'quantidade' => 10,
            'ativo' => true,
            'usuario_id' => $usuario1->id,
            'categoria_id' => $livros->id,
        ]);

        // Produto com quantidade zero, mas ativo Para testar validação do command
        Produto::create([
            'nome' => 'Notebook Acer Aspire',
            'valor' => 2800.00,
            'quantidade' => 0,
            'ativo' => true,
            'usuario_id' => $usuario1->id,
            'categoria_id' => $eletronicos->id,
        ]);

        // Produto desativado com quantidade maior que zero Para testar validação do command
        Produto::create([
            'nome' => 'Smartphone Samsung Galaxy',
            'valor' => 2200.00,
            'quantidade' => 7,
            'ativo' => false,
            'usuario_id' => $usuario1->id,
            'categoria_id' => $eletronicos->id,
        ]);

        Produto::create([
            'nome' => 'Camiseta Básica',
            'valor' => 49.90,
            'quantidade' => 15,
            'ativo' => true,
            'usuario_id' => $usuario2->id,
            'categoria_id' => $vestuario->id,
        ]);

        Produto::create([
            'nome' => 'Cadeira Gamer',
            'valor' => 899.00,
            'quantidade' => 3,
            'ativo' => true,
            'usuario_id' => $usuario2->id,
            'categoria_id' => $moveis->id,
        ]);

        Produto::create([
            'nome' => 'Café Premium',
            'valor' => 25.50,
            'quantidade' => 0,
            'ativo' => false,
            'usuario_id' => $usuario2->id,
            'categoria_id' => $alimentos->id,
        ]);

        Produto::create([
            'nome' => 'Teclado Mecânico',
            'valor' => 450.00,
            'quantidade' => 8,
            'ativo' => true,
            'usuario_id' => $usuario2->id,
            'categoria_id' => $eletronicos->id,
        ]);
    }
}
