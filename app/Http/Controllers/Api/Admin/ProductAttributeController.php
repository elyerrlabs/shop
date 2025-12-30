<?php

namespace Shop\App\Http\Controllers\Api\Admin;




use App\Http\Controllers\ApiController;
use Shop\App\Services\ProductService;

final class ProductAttributeController extends ApiController
{

    /**
     *  repository
     * @var ProductService
     */
    private $productService;

    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
        $this->middleware('scope:administrator:ecommerce:full, administrator:ecommerce:delete')->only('destroy');
    }

    /**
     * Delete tag from the model
     * @param string $product_id
     * @param string $tag_id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(string $product_id, string $tag_id)
    {
        $model = $this->productService->deleteAttribute($product_id, $tag_id);

        return $this->showOne($model);
    }
}
