<?php

namespace Shop\App\Http\Controllers\Web;

use Shop\App\Services\RouteService;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\WebController;

class ProductController extends WebController
{
    /**
     * Construct
     */
    public function __construct()
    {
        // public controller - disabled authentication
    }

    /**
     * dashboard
     * @return \Inertia\Response
     */
    public function dashboard()
    {
        return Inertia::render(
            'Web/Dashboard',
            [
                'routes' => [ // share web routes
                    'search' => route('module.shop.web.search'),
                ],
                'api' => RouteService::api() // share api route
            ]
        )->rootView('ecommerce');
    }

    /**
     * Show products for users
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render(
            'Web/Search',
            [
                'routes' => [// share web routes
                    'dashboard' => route('module.shop.web.dashboard'),
                    'search' => route('module.shop.web.search'),
                ],
                'api' => RouteService::api() // share api route
            ]
        )->rootView('ecommerce');
    }

    /**
     * Show product buy
     * @param \Illuminate\Http\Request $request
     * @param string $category
     * @return mixed|\Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function category(Request $request, string $category = null)
    {
        return Inertia::render(
            'Web/Search',
            [
                'routes' => [// share web routes
                    'dashboard' => route('module.shop.web.dashboard'),
                    'search' => route('module.shop.web.category', ['category' => $category]),
                ],
                'api' => RouteService::api() // share api route
            ]
        )->rootView('ecommerce');
    }

    /**
     * show product details
     * @param string $category
     * @param string $product
     * @return mixed|\Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function productDetails(string $category_slug, string $product_slug)
    {
        return Inertia::render(
            'Web/Show',
            [
                'routes' => [// share web routes
                    'search' => route('module.shop.web.search'),
                    'dashboard' => route('module.shop.web.dashboard'),
                    'orders' => route('module.shop.web.orders.index'),
                    'show' => route('module.shop.web.category', [
                        'category' => $category_slug
                    ]),
                ],
                'api' => RouteService::api([
                    "product_show" => route('module.shop.api.web.products.show', [
                        'category' => $category_slug,
                        'product' => $product_slug
                    ])
                ]) // share api route
            ]
        )->rootView('ecommerce');
    }
}
