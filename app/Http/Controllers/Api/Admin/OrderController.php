<?php

namespace Shop\App\Http\Controllers\Api\Admin; 

use Shop\App\Services\CheckoutService; 
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Shop\App\Transformer\Admin\CheckoutTransformer;

class OrderController extends ApiController
{
    /**
     * Checkout Service
     * @var CheckoutService
     */
    private $checkoutService;


    public function __construct(CheckoutService $checkoutService)
    {
        parent::__construct();
        $this->middleware("scope:administrator:ecommerce:full,administrator:ecommerce:view");
        $this->checkoutService = $checkoutService;
    }

    /**
     * Show orders
     * @param \Illuminate\Http\Request $request
     */
    public function complete(Request $request)
    {
        $query = $this->checkoutService->search($request);

        return $this->showAllByBuilder($query, CheckoutTransformer::class);
    }


    /**
     * Show orders
     * @param \Illuminate\Http\Request $request
     */
    public function pending(Request $request)
    {
        $query = $this->checkoutService->search($request);

        return $this->showAllByBuilder($query, CheckoutTransformer::class);
    }
}