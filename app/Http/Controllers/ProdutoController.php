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
}
