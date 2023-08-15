<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnderecosResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array(
            "id" => $this->id,
            "cep" => $this->cep,
            "logradouro" => $this->logradouro,
            "bairro" => $this->bairro,
            "cidade" => $this->cidade,
            "uf" => $this->uf,
            "created_at" => date('Y-m-d H:i:s', strtotime($this->created_at)),
            "updated_at" => date('Y-m-d H:i:s', strtotime($this->updated_at))
        );
    }
}
