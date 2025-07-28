<?php
namespace App\Services;

use App\Models\Championship;
use App\DTOs\ChampionshipDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ChampionshipService
{
    public function list($request): LengthAwarePaginator
    {
        $championships = Championship::Filter($request->only(['name']))
                        ->orderBy('name')
                        ->paginate(10);

        $championships->getCollection()->transform(function($category){
            return ChampionshipDTO::fromModel($category);
        });

        return $championships;
    }

    public function getListAll()
    {
        return Championship::all();
    }

    public function create(ChampionshipDTO $championship): Championship
    {
        return Championship::create($championship->toArray());
    }

    public function update(ChampionshipDTO $championshipDTO, ?Championship $championship = null): bool
    {
        return $championship->update($championshipDTO->toArray());
    }

    public function show(Championship $category): ChampionshipDTO
    {
        return ChampionshipDTO::fromModel($category);
    }

    public function delete(Championship $championship): void
    {
        $championship = Championship::find($championship->id);
        $championship->delete();
    }
}
