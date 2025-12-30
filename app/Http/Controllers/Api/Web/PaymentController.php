<?php

namespace Shop\App\Http\Controllers\Api\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Shop\App\Services\CheckoutService;

class PaymentController extends ApiController
{
    /**
     * Repository
     * @var CheckoutService
     */
    private $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        parent::__construct();
        $this->checkoutService = $checkoutService;

    }

    /**
     * Add new order
     * @param Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'payment_method' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (is_null(billing_get_method($value))) {
                        $fail(__("The payment method is not valid"));
                    }
                }
            ],
            'delivery' => ['required', 'exists:delivery_addresses,id'],
            'orders' => ['required', 'array'],
            'orders.*.id' => ['exists:orders,id'],
            'orders.*.variant_id' => ['exists:variants,id'],
            'orders.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        return $this->checkoutService->create($request->toArray());
    }
}
