<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comunidade;
use App\Http\Resources\ComunidadeResource;
use Illuminate\Http\JsonResponse;

class ComunidadeController extends Controller
{
    public function index(): JsonResponse
    {
        $comunidades = Comunidade::all();
        return response()->json(ComunidadeResource::collection($comunidades));
    }

    public function show($id): JsonResponse
    {
        $comunidade = Comunidade::findOrFail($id);
        return response()->json(new ComunidadeResource($comunidade));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'tema' => 'required|string|max:255',
            'atividades' => 'array',
            'descricao' => 'nullable|string',
        ]);

        $comunidade = Comunidade::create($request->all());
        if ($request->has('membros')) {
            $comunidade->membros()->sync($request->membros);
        }

        return response()->json(new ComunidadeResource($comunidade), 201);
    }

    public function destroy($id): JsonResponse
    {
        $comunidade = Comunidade::findOrFail($id);
        $comunidade->delete();

        return response()->json(null, 204);
    }
}
