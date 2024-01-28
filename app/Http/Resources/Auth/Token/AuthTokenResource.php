<?php

namespace App\Http\Resources\Auth\Token;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthTokenResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'token' => $this->plainTextToken,
        ];
    }
}
