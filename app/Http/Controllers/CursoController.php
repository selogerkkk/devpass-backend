<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CursoController extends Controller
{
    public function inscreverUsuario(Request $request, $curso_id): JsonResponse
    {
        $user = auth()->user();
        $curso = Curso::findOrFail($curso_id);

        if ($user->cursos()->where('curso_id', $curso_id)->exists()) {
            return response()->json(['message' => 'O usuário já está inscrito neste curso.'], 400);
        }

        $user->cursos()->attach($curso_id);

        return response()->json(['message' => 'Usuário inscrito no curso com sucesso.'], 201);
    }

    public function listarCursos(): JsonResponse
    {
        $cursos = Curso::all();

        return response()->json(['cursos' => $cursos]);
    }

    public function listarCurso($id): JsonResponse
    {
        $curso = Curso::findOrFail($id);

        return response()->json(['curso' => $curso]);
    }

    public function cadastrarCurso(Request $request): JsonResponse
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'professor' => 'required|string|max:255',
            'conteudo' => 'required|array',
            'conteudo.*.titulo' => 'required|string|max:255',
            'conteudo.*.url' => 'required|string',
            'duracao' => 'required|string|max:255',
            'preco' => 'required|numeric',
        ]);

        $curso = Curso::create(array_merge($request->all(), [
            'conteudo' => json_encode($request->conteudo)
        ]));

        return response()->json(['message' => 'Curso cadastrado com sucesso.', 'curso' => $curso], 201);
    }

    public function atualizarCurso(Request $request, $id): JsonResponse
    {
        $curso = Curso::findOrFail($id);

        $request->validate([
            'titulo' => 'string|max:255',
            'descricao' => 'string',
            'professor' => 'string|max:255',
            'conteudo' => 'array',
            'duracao' => 'string|max:255',
            'preco' => 'numeric',
        ]);

        $curso->update($request->all());

        return response()->json(['message' => 'Curso atualizado com sucesso.', 'curso' => $curso]);
    }

    public function excluirCurso($id): JsonResponse
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        return response()->json(['message' => 'Curso excluído com sucesso.']);
    }
}
