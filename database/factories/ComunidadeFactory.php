<?php

namespace Database\Factories;

use App\Models\Comunidade;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComunidadeFactory extends Factory
{
    protected $model = Comunidade::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->word,
            'tema' => $this->faker->sentence,
            'atividades' => $this->faker->randomElements([
                'Discussão', 'Aprendizado', 'Workshop', 'Networking', 'Laravel'
            ], rand(1, 5)),
        ];
    }
}
