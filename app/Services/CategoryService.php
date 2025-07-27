<?php

namespace App\Services;

use App\Models\Category;
use App\DTOs\CategoryDTO;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\CategoryNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService {

    public function list($request): LengthAwarePaginator
    {
        $categories = Category::Filter($request->only(['description']))
                        ->orderBy('description')
                        ->paginate(10);

        $categories->getCollection()->transform(function($category){
            return CategoryDTO::fromModel($category);
        });

        return $categories;
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
        $category = Category::find($category->id);
        $category->delete();
    }
}