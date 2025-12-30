<?php

namespace Shop\App\Http\Controllers\Api\Web;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Shop\App\Services\ProductService;
use Shop\App\Transformer\User\UserProductTransformer;

class ProductController extends ApiController
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * Construct
     * @param  ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Show products for users
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function index(Request $request)
    {
        $query = $this->productService->searchForUsers($request);

        return $this->showAllByBuilder($query, UserProductTransformer::class);
    }

    /**
     * show product details
     * @param string $category
     * @param string $product
     * @return mixed|\Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function productDetails(string $category_slug, string $product_slug)
    {
        $model = $this->productService->findProductByCategoryForUser($category_slug, $product_slug);

        return $this->showOne($model, UserProductTransformer::class);
    }
}