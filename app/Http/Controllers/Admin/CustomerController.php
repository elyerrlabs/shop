<?php

namespace Shop\App\Http\Controllers\Admin;



use Inertia\Inertia;
use Shop\App\Services\RouteService;
use Illuminate\Http\Request;
use App\Http\Controllers\WebController;

class CustomerController extends WebController
{
    public function __construct()
    {
        $this->middleware("userCanAny:administrator:ecommerce:full,administrator:ecommerce:view");
    }

    /**
     * Customers
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render(
            "Admin/Order/Customer",
            [
                'api' => RouteService::admin(),
                'ecommerce_menus' => resolveInertiaRoutes(config('menus.shop_menus'))
            ]
        );
    }
}