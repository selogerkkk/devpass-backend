<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $fillable = [
        'formacao',
        'habilidades'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
