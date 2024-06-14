<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'professor',
        'conteudo',
        'duracao',
        'preco',
        'thumb',
        'rating',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
