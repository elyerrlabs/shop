<?php

namespace Shop\App\Http\Controllers\Admin;



use Shop\App\Services\ProductService;
use Shop\App\Transformer\Admin\ProductTransformer;
use Inertia\Inertia;
use Shop\App\Services\RouteService;
use Illuminate\Http\Request;
use App\Http\Controllers\WebController;

final class ProductController extends WebController
{

    /**
     * Product Service
     * @var ProductService
     */
    private $productService;

    /**
     *Construct
     *  
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('userCanAny:administrator:ecommerce:full, administrator:ecommerce:view');
        $this->productService = app(ProductService::class);
    }

    /**
     * Show the all resource
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render(
            'Admin/Product/Index',
            [
                'routes' => [
                    'index' => route('module.shop.admin.products.index'),
                    'create' => route('module.shop.admin.products.create'),
                ],
                'api' => RouteService::admin(), // api routes
                'ecommerce_menus' => resolveInertiaRoutes(config('menus.shop_menus'))
            ]
        );
    }

    /**
     * Create product
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render(
            'Admin/Product/Create',
            [
                'routes' => [
                    'index' => route('module.shop.admin.products.index'),
                ],
                'admin' => RouteService::admin(),
                'ecommerce_menus' => resolveInertiaRoutes(config('menus.shop_menus'))
            ]
        );
    }

    /**
     * Edit product
     * @param string $id
     * @return \Inertia\Response
     */
    public function edit(string $id)
    {
        $data = $this->transform($this->productService->find($id), ProductTransformer::class);

        return Inertia::render(
            'Admin/Product/Create',
            [
                'data' => $data,
                'routes' => [
                    'index' => route('module.shop.admin.products.index'),
                    'preview' => route('module.shop.admin.product.preview', [
                        'category' => $data['category']['slug'],
                        'product' => $data['slug'],
                    ]),
                ],
                'admin' => RouteService::admin(),
                'ecommerce_menus' => resolveInertiaRoutes(config('menus.shop_menus'))
            ]
        );
    }


    /**
     * show product details as a user
     * @param string $category
     * @param string $product
     * @return mixed|\Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function viewAsUser(string $category_slug, string $product_slug)
    {
        return Inertia::render(
            'Web/Show',
            [
                'routes' => [// share web routes
                    'search' => route('module.shop.web.search'),
                    'dashboard' => route('module.shop.web.dashboard'),
                    'orders' => route('module.shop.orders.index'),
                    'show' => route('module.shop.web.category', [
                        'category' => $category_slug
                    ]),
                ],
                'api' => RouteService::api([
                    "product_show" => route('module.shop.api.admin.preview.product', [
                        'category' => $category_slug,
                        'product' => $product_slug
                    ])
                ]) // share api route
            ]
        )->rootView('ecommerce');
    }
}
