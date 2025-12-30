<?php

namespace Shop\App\Http\Controllers\Api\Web;
 
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Shop\App\Services\CheckoutService;
use Shop\App\Transformer\User\UserCheckoutTransformer;

class CheckoutController extends ApiController
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
     * Index
     * @param \Illuminate\Http\Request $request
     * @return  \Inertia\Response
     */
    public function index(Request $request)
    {   // 
        $query = $this->checkoutService->searchForUser($request);

        return $this->showAllByBuilder($query, UserCheckoutTransformer::class);
    }


    public function show($id)
    {
        $checkout = $this->checkoutService->details($id);

        return $this->showOne($checkout, UserCheckoutTransformer::class);
    }
}
