<?php

namespace Shop\App\Http\Controllers\Admin;



use Shop\App\Services\RouteService;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\WebController;

class OrderController extends WebController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware("userCanAny:administrator:ecommerce:full,administrator:ecommerce:view");
    }

    /**
     * Show orders
     * @param \Illuminate\Http\Request $request
     */
    public function complete(Request $request)
    {
        return Inertia::render('Admin/Order/Complete', [
            'api' => RouteService::admin(),
            'ecommerce_menus' => resolveInertiaRoutes(config('menus.shop_menus'))
        ]);
    }


    /**
     * Show orders
     * @param \Illuminate\Http\Request $request
     */
    public function pending(Request $request)
    {
        return Inertia::render('Admin/Order/Pending', [
            'api' => RouteService::admin(),
            'ecommerce_menus' => resolveInertiaRoutes(config('menus.shop_menus'))
        ]);
    }
}