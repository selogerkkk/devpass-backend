<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    protected $model = Curso::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence,
            'descricao' => $this->faker->paragraph,
            'professor' => $this->faker->name,
            'conteudo' => json_encode($this->faker->paragraphs(rand(2, 5))),
            'duracao' => $this->faker->randomElement(['1 hora', '2 horas', '3 horas']),
            'preco' => $this->faker->randomFloat(2, 10, 100),
            'thumb' => $this->faker->imageUrl(640, 480, 'cursos', true),
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}
