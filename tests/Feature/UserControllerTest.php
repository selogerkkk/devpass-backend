<?php

namespace Tests\Feature;

use App\Models\Comunidade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Comunidade::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testListarUsuarios(): void
    {
        User::factory()->count(2)->create();

        $response = $this->get(route('.users.index'));

        $response->assertOk()
            ->assertJsonCount(4)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'email',
                    'participacao_em_comunidades'
                ],
            ]);
    }

    public function testCriarUsuario(): void
    {
        $user_data = [
            'name' => 'Teste',
            'email' => 'teste@example.com',
            'password' => 'password',
        ];

        $response = $this->post(route('.users.store'), $user_data);

        $response->assertCreated()
            ->assertJsonStructure([
                'id',
                'name',
                'email',
            ]);
    }

    public function testExcluirUsuario(): void
    {
        $user = User::factory()->create();

        $response = $this->delete(route('.users.destroy', ['id' => $user->id]));

        $response->assertSuccessful();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function testInscricaoComunidade(): void
    {
        $comunidade_id = 1;

        $response = $this->post(
            route('.users.subscribe', ['id' => $this->user->id]),
            ['comunidade_id' => $comunidade_id]
        );

        $response->assertOk()
            ->assertJson(['message' => 'Usuário inscrito na comunidade com sucesso.']);

        $this->assertTrue($this->user->participacaoEmComunidades()->where('comunidade_id', $comunidade_id)->exists());
    }
}
