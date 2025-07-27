<?php

namespace App\DTOs;

use App\Models\Category;
use Illuminate\Support\Facades\Request;

class CategoryDTO {

    public function __construct(
        public readonly ?int $id,
        public readonly string $description
    ) {}


    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id')?? null,
            description: $request->input('description')
        );
    }

    public static function fromModel(Category $category): self
    {
        return new self(
            id: $category->id,
            description: $category->description
        );
    }
    
    public static function fromArray(array $data): self
    {
        return new self(
           id: $data['id'] ?? null,
            description: $data['description']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
        ];
    }
}