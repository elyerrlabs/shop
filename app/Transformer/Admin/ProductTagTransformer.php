<?php

namespace Shop\App\Transformer\Admin;

use App\Models\Common\Tag;
use Shop\App\Models\Product; 
use League\Fractal\TransformerAbstract;

class ProductTagTransformer extends TransformerAbstract
{

    /**
     * product
     * @var Product
     */
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
    public function transform(Tag $tag)
    {
        return [
            'id' => $tag->id,
            'name' => $tag->name,
            'slug' => $tag->slug,
            'links' => [
                'destroy' => route('module.shop.api.admin.products.tags.destroy', [
                    'product' => $this->product->id,
                    'tag' => $tag->id
                ])
            ],
        ];
    }
}
