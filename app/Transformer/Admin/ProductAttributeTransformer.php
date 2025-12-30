<?php

namespace Shop\App\Transformer\Admin;
 
use App\Models\Common\Attribute;
use Shop\App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductAttributeTransformer extends TransformerAbstract
{

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Attribute $attribute)
    {
        return [
            'name' => ucfirst($attribute->name),
            'slug' => strtolower($attribute->slug),
            'type' => strtolower($attribute->type),
            'value' => $attribute->value,
            'widget' => strtolower($attribute->widget),
            'multiple' => $attribute->multiple ? true : false,
            'stock' => $attribute->pivot->stock,
            //'unit_id'
            'links' => [
                'destroy' => route('module.shop.api.admin.products.attributes.destroy', [
                    'product' => $this->product->id,
                    'attribute' => $attribute->id
                ])
            ],
        ];
    }
}
