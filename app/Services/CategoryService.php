<?php

namespace App\Services;

use App\DTOs\CategoryDTO;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function list($request): LengthAwarePaginator
    {
        $paginator = $this->getFilteredPaginated($request);

        $paginator->getCollection()->transform(function ($category) {
            return CategoryDTO::fromModel($category);
        });

        return $paginator;
    }

    public function getListAll(): Collection
    {
        return Category::all();
    }

    public function create(CategoryDTO $category): Category
    {
        return Category::create($category->toArray());
    }

    public function update(CategoryDTO $categoryDTO, ?Category $category = null): bool
    {
        return $category->update($categoryDTO->toArray());
    }

    public function show(Category $category): CategoryDTO
    {
        return CategoryDTO::fromModel($category);
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }

    public function getFilteredPaginated(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        return Category::select('id', 'description', 'status')
                    ->filter($filters)
                    ->orderBy('description')
                    ->paginate($perPage);
    }
}
