@section('title', 'Editar Produto')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Produto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('produtos.update', $produto) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nome" class="block text-gray-700 text-sm font-bold mb-2">
                                Nome do Produto *
                            </label>
                            <input type="text" name="nome" id="nome" value="{{ old('nome', $produto->nome) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nome') border-red-500 @enderror"
                                required autofocus>
                            @error('nome')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-600 text-xs mt-1">Mínimo 3 caracteres, máximo 120 caracteres</p>
                        </div>

                        <div class="mb-4">
                            <label for="categoria_id" class="block text-gray-700 text-sm font-bold mb-2">
                                Categoria *
                            </label>
                            <select name="categoria_id" id="categoria_id"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('categoria_id') border-red-500 @enderror"
                                required>
                                <option value="">Selecione uma categoria</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ old('categoria_id', $produto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="valor" class="block text-gray-700 text-sm font-bold mb-2">
                                Valor (R$) *
                            </label>
                            <input type="number" name="valor" id="valor" value="{{ old('valor', $produto->valor) }}"
                                step="0.01" min="0.01"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('valor') border-red-500 @enderror"
                                required>
                            @error('valor')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-600 text-xs mt-1">Valor deve ser maior que zero</p>
                        </div>

                        <div class="mb-4">
                            <label for="quantidade" class="block text-gray-700 text-sm font-bold mb-2">
                                Quantidade
                            </label>
                            <input type="number" name="quantidade" id="quantidade"
                                value="{{ old('quantidade', $produto->quantidade) }}" min="0"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('quantidade') border-red-500 @enderror">
                            @error('quantidade')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-600 text-xs mt-1">Produtos com quantidade > 0 ficam ativos
                                automaticamente</p>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('produtos.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Atualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>