<?php

namespace Shop\App\Repositories;

use Shop\App\Transformer\Admin\VariantTransformer;
use Shop\App\Models\Variant;
use Shop\App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Shop\App\Repositories\ProductRepository;

class OrderRepository
{
    /**
     * Model
     * @var
     */
    private $model;

    private $productRepository;

    /**
     * Construct
     * @param \Shop\App\Models\Order $order
     * @param \Shop\App\Repositories\ProductRepository $productRepository
     */
    public function __construct(Order $order, ProductRepository $productRepository)
    {
        $this->model = $order;
        $this->productRepository = $productRepository;
    }

    /**
     * Create query
     * @return \Illuminate\Database\Eloquent\Builder<Order>
     */
    public function query()
    {
        $query = $this->model->query();

        $query->with([
            'user',
            'orderable',
            'orderable.variantable.files',
            'orderable.price'
        ]);

        return $query;
    }


    /**
     * Create order
     * @param array $data
     * @return Order|TModel|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Find Order
     * @param string $id
     * @return object|\Illuminate\Database\Eloquent\Builder<Order>|\Illuminate\Database\Eloquent\Model|null
     */
    public function find(string $id)
    {
        return $this->query()->where('id', $id)->first();
    }

    /**
     * Update order
     * @param string $id
     * @param array $data
     * @return object|\Illuminate\Database\Eloquent\Builder<Order>|\Illuminate\Database\Eloquent\Model|null
     */
    public function update(string $id, array $data)
    {
        $order = $this->find($id);
        $order->update($data);
        return $order;
    }
}
