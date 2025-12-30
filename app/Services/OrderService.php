<?php

namespace Shop\App\Services;

use Illuminate\Http\Request;
use Shop\App\Models\Variant;
use Shop\App\Repositories\OrderRepository;
use Shop\App\Transformer\Admin\VariantTransformer;

class OrderService
{
    /**
     * Order repository
     * @var  OrderRepository
     */
    private $orderRepository;


    public function __construct()
    {
        $this->orderRepository = app(OrderRepository::class);
    }

    /**
     * Search unpaid orders for user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder<Order>
     */
    public function searchForUser(Request $request)
    {
        $query = $this->orderRepository->query();

        $query->where('user_id', auth()->user()->id);

        $query->whereNull('checkout_id');

        if ($request->filled('quantity')) {
            $query->where('quantity', $request->quantity);
        }

        return $query;
    }


    /**
     * Create new Order
     * @param array $data
     * @return Order|TModel|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $variant = Variant::find($data['variant_id']);

        $data['meta'] = $variant->variantable->toArray();
        $data['meta']['category'] = $variant->variantable->category->toArray();
        $data['meta']['variant'] = fractal($variant, VariantTransformer::class)->toArray()['data'];

        unset($data['meta']['variant']['links']);

        return $variant->orders()->create($data);
    }

    /**
     * Update order
     * @param string $id
     * @param array $data
     * @return object|\Illuminate\Database\Eloquent\Builder<\Shop\App\Models\Order>|\Illuminate\Database\Eloquent\Model|null
     */
    public function update(string $id, array $data)
    {
        return $this->orderRepository->update($id, $data);
    }

    /**
     * Order repository
     * @param string $id
     * @return object|\Illuminate\Database\Eloquent\Builder<\Shop\App\Models\Order>|\Illuminate\Database\Eloquent\Model|null
     */
    public function delete(string $id)
    {
        $order = $this->orderRepository->find($id);

        if (!empty($order) && empty($order->transaction_id)) {
            $order->delete();
        }

        return $order;
    }
}
