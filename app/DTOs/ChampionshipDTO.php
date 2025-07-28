<?php

namespace App\DTOs;

use App\Models\Championship;
use Illuminate\Support\Facades\Request;

class ChampionshipDTO {

    public function __construct(
        public readonly ?int $id,
        public readonly int $category_id,
        public readonly string $name,
        public readonly ?string $avatar,
        public readonly int $status
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id')?? null,
            category_id: $request->input('category_id'),
            name: $request->input('name'),
            avatar: $request->input('avatar') ?? null,
            status: $request->input('status'),
        );
    }

    public static function fromModel(Championship $championship): self
    {
        return new self(
            id: $championship->id?? null,
            category_id: $championship->category_id,
            name: $championship->name,
            avatar: $championship->avatar ?? null,
            status: $championship->status,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            category_id: $data['category_id'],
            name: $data['name'],
            avatar: $data['avatar'] ?? null,
            status: $data['status'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'avatar' => $this->avatar,
            'status' => $this->status,
        ];
    }
}