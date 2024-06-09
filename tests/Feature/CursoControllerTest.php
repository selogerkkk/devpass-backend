<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Curso;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CursoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListarCursos(): void
    {
        Curso::factory()->count(3)->create();

        $response = $this->get(route('.cursos.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'cursos' => [
                    '*' => [
                        'id',
                        'titulo',
                        'descricao',
                        'professor',
                        'conteudo',
                        'duracao',
                        'preco',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }

    public function testCadastrarCurso(): void
    {
        $curso_data = [
            'titulo' => 'Novo Curso',
            'descricao' => 'Descrição do Novo Curso',
            'professor' => 'Professor do Novo Curso',
            'conteudo' => json_encode(['Aula 1', 'Aula 2']),
            'duracao' => '10 horas',
            'preco' => 50.00,
        ];

        $response = $this->post(route('.cursos.store'), $curso_data);

        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'Curso cadastrado com sucesso.'])
            ->assertJsonStructure([
                'message',
                'curso' => [
                    'id',
                    'titulo',
                    'descricao',
                    'professor',
                    'conteudo',
                    'duracao',
                    'preco',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function testInscreverUsuario(): void
    {
        $usuario = User::factory()->create();
        $curso = Curso::factory()->create();

        $response = $this->post(route('.cursos.purchase', ['cursoId' => $curso->id]), ['user_id' => $usuario->id]);

        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'Usuário inscrito no curso com sucesso.'])
            ->assertJsonStructure(['message']);
    }

    public function testAtualizarCurso(): void
    {
        $curso = Curso::factory()->create();
        $curso_atualizado = [
            'titulo' => 'Curso Atualizado',
            'descricao' => 'Descrição do Curso Atualizado',
            'professor' => 'Novo Professor',
            'conteudo' => ['Aula 1', 'Aula 2', 'Aula 3'],
            'duracao' => '15 horas',
            'preco' => 75.00,
        ];

        $response = $this->put(route('.cursos.update', ['id' => $curso->id]), $curso_atualizado);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Curso atualizado com sucesso.']);
    }

    public function testExcluirCurso(): void
    {
        $curso = Curso::factory()->create();

        $response = $this->delete(route('.cursos.destroy', ['id' => $curso->id]));

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Curso excluído com sucesso.']);
    }
}
