<?php

namespace App\Services;

use App\DTOs\RoundDTO;
use App\Models\Round;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RoundService
{
    public function list($request): LengthAwarePaginator
    {
        $paginator = $this->getFilteredPaginated($request);

        $paginator->getCollection()->transform(function ($round) {
            return RoundDTO::fromModel($round);
        });

        return $paginator;
    }

    public function getListAll(): Collection
    {
        return Round::all();
    }

    public function create(RoundDTO $round): Round
    {
        return Round::create($round->toArray());
    }

    public function update(RoundDTO $roundDTO, Round $round): bool
    {
        return $round->update($roundDTO->toArray());
    }

    public function show(Round $round): RoundDTO
    {
        return RoundDTO::fromModel($round);
    }

    public function delete(Round $round): void
    {
        $round->delete();
    }

    public function getFilteredPaginated(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        return Round::select('id', 'description', 'status')
                    ->filter($filters)
                    ->orderBy('description')
                    ->paginate($perPage);
    }
}
