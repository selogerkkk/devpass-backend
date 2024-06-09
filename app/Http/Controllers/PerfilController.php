<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfil;
use Illuminate\Http\JsonResponse;

class PerfilController extends Controller
{
    public function show($user_id): JsonResponse
    {
        $perfil = Perfil::where('user_id', $user_id)->first();

        if (!$perfil) {
            return response()->json(['message' => 'Perfil não encontrado.'], 404);
        }

        return response()->json(['perfil' => $perfil]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'formacao' => 'required|string',
            'habilidades' => 'required|string',
        ]);

        $perfil = Perfil::create($request->all());

        return response()->json(['message' => 'Perfil criado com sucesso.', 'perfil' => $perfil], 201);
    }

    public function update(Request $request, $user_id): JsonResponse
    {
        $perfil = Perfil::where('user_id', $user_id)->first();

        if (!$perfil) {
            return response()->json(['message' => 'Perfil não encontrado.'], 404);
        }

        $request->validate([
            'formacao' => 'string',
            'habilidades' => 'string',
        ]);

        $perfil->update($request->all());

        return response()->json(['message' => 'Perfil atualizado com sucesso.', 'perfil' => $perfil]);
    }

    public function destroy($user_id): JsonResponse
    {
        $perfil = Perfil::where('user_id', $user_id)->first();

        if (!$perfil) {
            return response()->json(['message' => 'Perfil não encontrado.'], 404);
        }

        $perfil->delete();

        return response()->json(['message' => 'Perfil excluído com sucesso.']);
    }
}
