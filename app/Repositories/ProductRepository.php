<?php

namespace Shop\App\Repositories;

use Shop\App\Models\Product;

final class ProductRepository
{

    /**
     * Product
     * @var Product
     */
    public $model;

    /**
     * Summary of storage
     * @var
     */
    private $storage;

    /**
     * Category repository
     * @var CategoryRepository
     */
    private $category_repository;

    public function __construct(Product $product)
    {
        $this->model = $product;
        $this->storage = "products";
    }

    /**
     * The storage file
     * @return string
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Query
     * @return \Illuminate\Database\Eloquent\Builder<Product>
     */
    public function query()
    {
        $query = $this->model->query();

        $query->with([
            'category',
            'files',
            'tags',
            'attributes',
            'variants',
            'variants.price',
            'children'
        ]);

        return $query;
    }


    /**
     * Search specific resource
     * @param string $id
     * @return Product|null
     */
    public function find(string $id)
    {
        return $this->query()->where('id', $id)->first();
    }

    /**
     * Find by code
     * @param string $code
     * @return Product|TValue|null
     */
    public function findByCode(string $code)
    {
        return $this->query()->where('code', $code)->first();
    }

    /**
     * Find by name
     * @param string $name
     * @return object|\Illuminate\Database\Eloquent\Builder<Product>|\Illuminate\Database\Eloquent\Model|null
     */
    public function findByName(string $name)
    {
        return $this->query()
            ->whereRaw(
                "LOWER(name) = ?",
                [strtolower($name)]
            )->first();
    }

    /**
     * Create new resource
     * @param array $data
     * @return Product|TModel|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update product
     * @param string $id
     * @param array $data
     * @return Product|null
     */
    public function update(string $id, array $data)
    {
        $product = $this->find($id);

        $product->update($data);

        return $product;
    }
}
