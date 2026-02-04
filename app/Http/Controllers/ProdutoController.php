<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $produtos = Produto::with('categoria')
            ->doUsuario(Auth::id())
            ->latest()
            ->paginate(15);

        return view('produtos.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('produtos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdutoRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::id();
        $data['ativo'] = ($data['quantidade'] ?? 0) > 0;

        Produto::create($data);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto): View
    {
        // Verifica se o produto pertence ao usuário logado
        if ($produto->usuario_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para editar este produto.');
        }

        $categorias = Categoria::orderBy('nome')->get();

        return view('produtos.edit', compact('produto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdutoRequest $request, Produto $produto): RedirectResponse
    {
        // Verifica se o produto pertence ao usuário logado
        if ($produto->usuario_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para atualizar este produto.');
        }

        $data = $request->validated();
        $data['ativo'] = ($data['quantidade'] ?? 0) > 0;

        $produto->update($data);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto): RedirectResponse
    {
        // Verifica se o produto pertence ao usuário logado
        if ($produto->usuario_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para excluir este produto.');
        }

        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}
