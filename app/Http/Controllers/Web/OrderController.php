<?php

namespace Shop\App\Http\Controllers\Web;

use Inertia\Inertia;
use Shop\App\Services\RouteService;
use Illuminate\Http\Request;
use App\Http\Controllers\WebController;

class OrderController extends WebController
{
    /**
     * Index
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render(
            'Web/Orders',
            [
                'routes' => [
                    'search' => route('module.shop.web.search'),
                    'dashboard' => route('module.shop.web.dashboard'),
                ],
                'api' => RouteService::api(),
            ]
        );
    }
}
