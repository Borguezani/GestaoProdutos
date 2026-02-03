<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'valor',
        'quantidade',
        'ativo',
        'usuario_id',
        'categoria_id',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'quantidade' => 'integer',
        'ativo' => 'boolean',
    ];

    /**
     * Relacionamento: Um produto pertence a um usuário
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento: Um produto pertence a uma categoria
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Scope para produtos ativos
     */
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Scope para produtos de um usuário específico
     */
    public function scopeDoUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }
}
