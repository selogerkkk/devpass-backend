<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all();
        return response()->json(UserResource::collection($users));
    }

    public function show($id): JsonResponse
    {
        $user = User::findOrFail($id);
        return response()->json(new UserResource($user));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        if ($request->has('participacao_em_comunidades')) {
            $user->participacaoEmComunidades()->sync($request->participacao_em_comunidades);
        }

        return response()->json(new UserResource($user), 201);
    }

    public function destroy($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

    public function subscribeToCommunity(Request $request, $id): JsonResponse
    {
        $request->validate([
            'comunidade_id' => 'required|exists:comunidades,id',
        ]);

        $user = User::findOrFail($id);
        $comunidade_id = $request->input('comunidade_id');

        if ($user->participacaoEmComunidades()->where('comunidade_id', $comunidade_id)->exists()) {
            return response()->json(['message' => 'Usuário já é membro dessa comunidade.'], 400);
        }

        $user->participacaoEmComunidades()->attach($comunidade_id);

        return response()->json(['message' => 'Usuário inscrito na comunidade com sucesso.'], 200);
    }
}
