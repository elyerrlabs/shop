<?php

namespace Shop\App\Http\Controllers\Web;

use Shop\App\Services\CheckoutService;
use Shop\App\Transformer\User\UserCheckoutTransformer;
use Inertia\Inertia;
use Shop\App\Services\RouteService;
use Illuminate\Http\Request;
use App\Http\Controllers\WebController;

class CheckoutController extends WebController
{
    /**
     * Checkout service
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
    {
        return Inertia::render(
            'Web/Checkout/Index',
            [
                'routes' => [
                    'search' => route('module.shop.web.search'),
                    'dashboard' => route('module.shop.web.dashboard'),
                ],
                'api' => RouteService::api(),
            ]
        );
    }

    /**
     * Refund product
     * @param Request $request
     * @return \Inertia\Response
     */
    public function show(string $id)
    {
        $data = $this->checkoutService->details($id);

        return Inertia::render(
            'Web/Checkout/Details',
            [
                'data' => $this->transform($data, UserCheckoutTransformer::class),
                'routes' => [
                    'show' => route('module.shop.checkouts.show', ['checkout' => $id]),
                    'search' => route('module.shop.web.search'),
                    'dashboard' => route('module.shop.web.dashboard'),
                ],
                'api' => RouteService::api(),
            ]
        );
    }
}
