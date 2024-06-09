<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Comunidade;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ComunidadeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListarComunidades(): void
    {
        Comunidade::factory()->count(3)->create();

        $response = $this->get(route('.comunidades.index'));

        $response->assertOk()
            ->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'nome',
                    'tema',
                    'atividades',
                ],
            ]);
    }

    public function testMostrarComunidade(): void
    {
        $comunidade = Comunidade::factory()->create();

        $response = $this->get(route('.comunidades.show', ['id' => $comunidade->id]));

        $response->assertOk()
            ->assertJson([
                'id' => $comunidade->id,
                'nome' => $comunidade->nome,
                'tema' => $comunidade->tema,
                'atividades' => $comunidade->atividades,
            ]);
    }

    public function testCriarComunidade(): void
    {
        $comunidade_data = [
            'nome' => 'Minha Comunidade',
            'tema' => 'Tema da Comunidade',
            'atividades' => ['Atividade 1', 'Atividade 2'],
        ];

        $response = $this->post(route('.comunidades.store'), $comunidade_data);

        $response->assertStatus(201)
            ->assertJson($comunidade_data);
    }

    public function testExcluirComunidade(): void
    {
        $comunidade = Comunidade::factory()->create();

        $response = $this->delete(route('.comunidades.destroy', ['id' => $comunidade->id]));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('comunidades', ['id' => $comunidade->id]);
    }
}
