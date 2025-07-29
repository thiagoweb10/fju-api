<?php

namespace App\DTOs;

use App\Models\Championship;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ChampionshipDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $category_id,
        public readonly string $name,
        public ?UploadedFile $logo = null,
        public ?string $logoPath = null,
        public readonly int $status
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id') ?? null,
            category_id: $request->input('category_id'),
            name: $request->input('name'),
            logo: $request->file('logo') ?? null,
            logoPath: null,
            status: $request->input('status'),
        );
    }

    public static function fromModel(Championship $championship): self
    {
        return new self(
            id: $championship->id ?? null,
            category_id: $championship->category_id,
            name: $championship->name,
            logo: null,
            logoPath: $championship->logo,
            status: $championship->status,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            category_id: $data['category_id'],
            name: $data['name'],
            logo: $data['logo'] ?? null,
            logoPath: $data['logo_path'] ?? null,
            status: $data['status'] ?? 1,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'logo' => $this->logoPath,
            'status' => $this->status,
        ];
    }

    public function setLogoPath(string $path): void
    {
        $this->logoPath = $path;
    }
}
