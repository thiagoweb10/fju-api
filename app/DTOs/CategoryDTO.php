<?php

namespace App\DTOs;

use App\Models\Category;
use Illuminate\Support\Facades\Request;

class CategoryDTO {

    public function __construct(
        public readonly ?int $id,
        public readonly string $name
    ) {}


    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id')?? null,
            name: $request->input('name')
        );
    }

    public static function fromModel(Category $category): self
    {
        return new self(
            id: $category->id,
            name: $category->name
        );
    }
    
    public static function fromArray(array $data): self
    {
        return new self(
           id: $data['id'] ?? null,
            name: $data['name']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}