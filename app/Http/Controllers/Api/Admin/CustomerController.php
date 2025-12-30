<?php

namespace Shop\App\Http\Controllers\Api\Admin;



use Shop\App\Transformer\Admin\UserTransformer;
use Shop\App\Services\CheckoutService;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CustomerController extends ApiController
{

    /**
     * Checkout service
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
     * Customers
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function index(Request $request)
    {
        $query = $this->checkoutService->listCustomers($request);

        return $this->showAllByBuilder($query, UserTransformer::class);
    }
}