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
}
