<?php

namespace Shop\App\Http\Controllers\Api\Admin;


use App\Http\Controllers\ApiController;
use Shop\App\Repositories\ProductRepository;
use Shop\App\Services\ProductService;

class ProductChildrenController extends ApiController
{
    /**
     * ProductRepository
     * @var ProductService
     */
    private $productService;

    /**
     * Summary of __construct
     * @param  ProductRepository $productRepository
     */
    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
        $this->middleware('scope:administrator:ecommerce:full, administrator:ecommerce:delete')->only('destroy');
    }

    /**
     * Unlink children to the product parent
     * @param string $product_id
     * @param string $children_id
     * @return \Shop\App\Models\Product|null
     */
    public function destroy(string $product_id, string $children_id)
    {
        $this->productService->deleteProductRelated($product_id, $children_id);
        return $this->message(__('Child deleted successfully'));
    }
}
