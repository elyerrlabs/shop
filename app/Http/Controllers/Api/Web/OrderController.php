<?php

namespace Shop\App\Http\Controllers\Api\Web;
 
use Shop\App\Services\OrderService;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Shop\App\Http\Requests\Order\StoreRequest;
use Shop\App\Transformer\User\UserOrderTransformer;

class OrderController extends ApiController
{
    /**
     * Repository
     * @var 
     */
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        parent::__construct();
        $this->orderService = $orderService;
    }

    /**
     * Show the all resource
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->orderService->searchForUser($request);

        return $this->showAllByBuilder($query, UserOrderTransformer::class);
    }

    /**
     * Add new order
     * @param \Shop\App\Http\Requests\Order\StoreRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $request->merge([
            'user_id' => auth()->user()->id,
        ]);

        $model = $this->orderService->create($request->toArray());

        return $this->showOne($model, UserOrderTransformer::class, 201);
    }

    /**
     * Destroy
     * @param string $order_id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(string $order_id)
    {
        $this->orderService->delete($order_id);

        return $this->message(__("Order deleted successfully"), 200);
    }
}
