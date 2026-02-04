<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProdutoController extends Controller
{
    /**
     * Listar todos os produtos ativos do sistema
     * 
     * GET /api/produtos
     */
    public function index(): AnonymousResourceCollection
    {
        $produtos = Produto::with(['categoria', 'usuario'])
            ->ativo()
            ->latest()
            ->get();

        return ProdutoResource::collection($produtos);
    }

    /**
     * Retornar um usuário e seus produtos
     * 
     * GET /api/usuarios/{usuario}/produtos
     */
    public function usuarioProdutos(User $usuario): JsonResponse
    {
        $usuario->load(['produtos.categoria']);

        return response()->json([
            'usuario' => [
                'id' => $usuario->id,
                'nome' => $usuario->name,
            ],
            'produtos' => ProdutoResource::collection($usuario->produtos),
        ]);
    }

    /**
     * Remover produto do estoque
     * 
     * PATCH /api/produtos/{produto}/remover
     */
    public function remover(Request $request, Produto $produto): JsonResponse
    {
        $request->validate([
            'quantidade' => ['required', 'integer', 'gt:0'],
        ], [
            'quantidade.required' => 'A quantidade é obrigatória.',
            'quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'quantidade.gt' => 'A quantidade deve ser maior que zero.',
        ]);

        $quantidadeRemover = $request->input('quantidade');

        if ($quantidadeRemover > $produto->quantidade) {
            return response()->json([
                'message' => 'Quantidade a remover é maior que a quantidade disponível em estoque.',
                'quantidade_disponivel' => $produto->quantidade,
            ], 422);
        }

        $produto->quantidade -= $quantidadeRemover;
        $produto->ativo = $produto->quantidade > 0;
        $produto->save();

        return response()->json([
            'produto' => [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'valor' => (float) $produto->valor,
                'quantidade' => $produto->quantidade,
            ],
        ], 200);
    }
}
