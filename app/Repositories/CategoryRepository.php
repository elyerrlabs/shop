<?php

namespace Shop\App\Repositories;

use Shop\App\Models\Product;
use Shop\App\Models\Category;

class CategoryRepository
{
    /**
     * Model
     * @var Category
     */
    private $model;

    /**
     * Storage
     * @var string
     */
    private $storage;

    /**
     * Construct
     * @param \Shop\App\Models\Category $category
     */
    public function __construct(Category $category)
    {
        $this->model = $category;
        $this->storage = "category";
    }

    /**
     * Get the storage name
     * @return string
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Query
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder<Category>
     */
    public function query()
    {
        $query = $this->model->query();

        // Only product categories
        $query->where('tag', Product::getTag());

        $query->with([
            'parent',
            'children',
            'icon',
            'files',
        ]);

        return $query;
    }

    /**
     * Create new resource
     * @param array $data
     * @return Category|TModel|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Search specific resource
     * @param string $id
     * @return TModel|TValue|null
     */
    public function find(string $id)
    {
        return $this->query()->where('id', $id)->first();
    }

    /**
     * Update category
     * @param string $id
     * @param array $data
     * @return Category|TModel|\Illuminate\Database\Eloquent\Model
     */
    public function update(string $id, array $data)
    {
        $model = $this->find($id);

        $model->update($data);

        return $model;
    }
}
