<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'professor',
        'conteudo',
        'duracao',
        'preco'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
