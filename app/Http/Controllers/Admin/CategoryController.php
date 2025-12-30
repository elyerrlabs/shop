<?php

namespace Shop\App\Http\Controllers\Admin;

 
use Shop\App\Services\CategoryService;
use Shop\App\Services\RouteService;
use Shop\App\Transformer\Admin\CategoryTransformer;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\WebController;

class CategoryController extends WebController
{

    /**
     * Category Service
     * @param  CategoryService
     */
    private $categoryService;

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('userCanAny:administrator:ecommerce:full, administrator:ecommerce:view');
        $this->categoryService = app(CategoryService::class);
    }

    /**
     * Show all resources
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Admin/Category/Index', [
            'routes' => [
                'index' => route('module.shop.admin.categories.index'),
                'create' => route('module.shop.admin.categories.create'),
            ],
            'api' => RouteService::admin(), // api routes
            'ecommerce_menus' => resolveInertiaRoutes(config('menus.shop_menus'))
        ]);
    }

    /**
     * Show detail
     * @param string $category_slug
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Category/Create', [
            'routes' => [
                'index' => route('module.shop.admin.categories.index'),
            ],
            'api' => RouteService::admin(), // api routes
            'ecommerce_menus' => resolveInertiaRoutes(config('menus.shop_menus'))
        ]);
    }

    /**
     * Edit
     * @param Request $request
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function edit(Request $request, string $id)
    {
        $data = $this->transform(
            $this->categoryService->details($id),
            CategoryTransformer::class
        );

        return Inertia::render('Admin/Category/Create', [
            'data' => $data,
            'routes' => [
                'index' => route('module.shop.admin.categories.index'),
            ],
            'api' => RouteService::admin(),
            'ecommerce_menus' => resolveInertiaRoutes(config('menus.shop_menus'))
        ]);
    }
}
