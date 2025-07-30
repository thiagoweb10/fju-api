<?php

namespace App\DTOs;

use App\Models\Round;
use Illuminate\Http\Request;

class RoundDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $championship_id,
        public readonly int $round_number,
        public readonly string $date_round,
        public readonly int $status_rounds_id,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id') ?? null,
            championship_id: $request->input('championship_id'),
            round_number: $request->input('round_number'),
            date_round: $request->input('date_round'),
            status_rounds_id: $request->input('status_rounds_id'),
        );
    }

    public static function fromModel(Round $round): self
    {
        return new self(
            id: $round->id,
            championship_id: $round->championship_id,
            round_number: $round->round_number,
            date_round: $round->date_round,
            status_rounds_id: $round->status_rounds_id,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            championship_id: $data['championship_id'],
            round_number: $data['round_number'],
            date_round: $data['date_round'],
            status_rounds_id: $data['status_rounds_id'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'championship_id' => $this->championship_id,
            'round_number' => $this->round_number,
            'date_round' => $this->date_round,
            'status_rounds_id' => $this->status_rounds_id,
        ];
    }
}
