<?php

namespace Shop\App\Http\Controllers\Api\Web; 

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Shop\App\Services\ProductService;
use Shop\App\Services\CategoryService;
use Shop\App\Transformer\User\UserProductTransformer;
use Shop\App\Transformer\User\UserCategoryTransformer;

final class CategoryController extends ApiController
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * Product Service
     */
    private $productService;

    public function __construct(CategoryService $categoryService, ProductService $productService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    /**
     * Show the all categories
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->categoryService->searchForUser($request);

        return $this->showAllByBuilder($query, UserCategoryTransformer::class);

    }

    /**
     * Show product by category
     * @param \Illuminate\Http\Request $request
     * @param string $category
     * @return mixed|\Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function show(Request $request, string $category = null)
    {
        $query = $this->productService->searchForUsers(
            $request,
            $category
        );

        return $this->showAllByBuilder($query, UserProductTransformer::class);
    }
}
