<?php

namespace Shop\App\Transformer\User;

use Shop\App\Models\Variant;
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
    public function transform(Variant $variant)
    {
        return [
            'id' => $variant->id,
            'name' => $variant->name,
            'stock' => filter_var($variant->stock, FILTER_VALIDATE_INT),
            'description' => $variant->description,
            'price' => $variant->price->amount,
            'currency' => $variant->price->currency,
            'symbol' => getCurrencySymbol($variant->price->currency),
            'format_price' => $this->formatMoney($variant->price->amount),
        ];
    }
}
