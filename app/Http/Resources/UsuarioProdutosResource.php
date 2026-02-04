<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioProdutosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'usuario' => [
                'id' => $this->id,
                'nome' => $this->name,
            ],
            'produtos' => ProdutoResource::collection($this->produtos),
        ];
    }
}
