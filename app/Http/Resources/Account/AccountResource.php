<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "timezone" => $this->timezone,
            "country" =>$this->country,
            "locale" => $this->locale,
            "owner" => $this->user,
            "role" => $this->role,
            "status" => $this->status,
            "preference" => $this->preference,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
