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
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('thumb')) {
            $path = $request->file('thumb')->store('thumbs', 'public');
            $data['thumb'] = $path;
        }

        $comunidade = Comunidade::create($data);

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
