<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'tema',
        'atividades',
        'membros',
        'descricao',
        'thumb',
    ];

    protected $casts = [
        'atividades' => 'array',
    ];

    public function membros()
    {
        return $this->belongsToMany(User::class, 'comunidade_user');
    }
}
