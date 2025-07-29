<?php

namespace App\Services;

use App\Contracts\FileUploadServiceInterface;
use App\DTOs\ChampionshipDTO;
use App\Models\Championship;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ChampionshipService
{
    public function __construct(
        protected FileUploadServiceInterface $fileUploadService
    ) {
    }

    public function list($request): LengthAwarePaginator
    {
        $championships = Championship::Filter($request)
                        ->orderBy('name')
                        ->paginate(10);

        $championships->getCollection()->transform(function ($championship) {
            return ChampionshipDTO::fromModel($championship);
        });

        return $championships;
    }

    public function getListAll(): Collection
    {
        return Championship::all();
    }

    public function create(ChampionshipDTO $championship): Championship
    {
        if ($championship->logo) {
            $path = $this->fileUploadService->upload($championship->logo, 'championships/logos');
            $championship->logoPath = $path;
        }

        return Championship::create($championship->toArray());
    }

    public function update(ChampionshipDTO $championshipDTO, Championship $championship): bool
    {
        if ($championshipDTO->logo) {
            $logoPath = $this->fileUploadService->upload($championshipDTO->logo, 'championships/logos');
            $championshipDTO->setLogoPath($logoPath);
        } else {
            $championshipDTO->setLogoPath($championship->logo);
        }

        return $championship->update($championshipDTO->toArray());
    }

    public function show(Championship $category): ChampionshipDTO
    {
        return ChampionshipDTO::fromModel($category);
    }

    public function delete(Championship $championship): void
    {
        $championship->delete();
    }

    public function getFilteredPaginated(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        return Championship::select('id', 'description', 'status')
                    ->with('category')
                    ->filter($filters)
                    ->orderBy('description')
                    ->paginate($perPage);
    }
}
