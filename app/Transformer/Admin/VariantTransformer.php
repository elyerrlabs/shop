<?php

namespace Shop\App\Transformer\Admin;

use Elyerr\ApiResponse\Assets\Asset;
use League\Fractal\TransformerAbstract;

class VariantTransformer extends TransformerAbstract
{
    use Asset;

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($variant)
    {
        return [
            'id' => $variant->id,
            'name' => $variant->name,
            'stock' => filter_var($variant->stock, FILTER_VALIDATE_INT),
            'stock_temp' => filter_var($variant->stock, FILTER_VALIDATE_INT),
            'description' => $variant->description,
            'price' => $variant->price->amount,
            'currency' => $variant->price->currency,
            'symbol' => getCurrencySymbol($variant->price->currency),
            'format_price' => $this->formatMoney($variant->price->amount),
            'links' => [
                'destroy' => route('module.shop.api.admin.products.variants.destroy', [
                    'product' => $variant->variantable_id,
                    'variant' => $variant->id
                ])
            ]
        ];
    }
}
