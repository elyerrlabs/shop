<?php

namespace Shop\App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use Shop\App\Services\ProductService;

final class ProductVariantController extends ApiController
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
    public function destroy(string $product_id, string $variant_id)
    {
        $this->productService->deleteVariant($product_id, $variant_id);

        return $this->message(__('Variant removed successfully'), 200);
    }
}
