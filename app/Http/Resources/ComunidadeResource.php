<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComunidadeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'tema' => $this->tema,
            'atividades' => $this->atividades,
            'descricao' => $this->descricao,
            'membros' => UserResource::collection($this->membros),
        ];
    }
}
