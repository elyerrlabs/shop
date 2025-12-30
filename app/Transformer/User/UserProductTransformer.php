<?php

namespace Shop\App\Transformer\User;

use Shop\App\Models\Product;
use Elyerr\ApiResponse\Assets\Asset;
use League\Fractal\TransformerAbstract;

class UserProductTransformer extends TransformerAbstract
{
    use Asset;

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
    public function transform(Product $product)
    {

        $variant = count($product->variants) ? $product->variants[0] : null;

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'published' => $product->published ? true : false,
            'featured' => $product->featured ? true : false,
            'stock' => !empty($variant) ? $product->variants->sum('stock') : 0,
            'price' => !empty($variant) ? $variant->price->amount : 0,
            'format_price' => !empty($variant) ? $this->formatMoney($variant->price->amount) : 0,
            'currency' => !empty($variant) ? $variant->price->currency : '',
            'symbol' => !empty($variant) ? getCurrencySymbol($variant->price->currency) : '',
            'category' => fractal($product->category, UserCategoryTransformer::class)->toArray()['data'] ?? [],
            'images' => fractal($product->files, UserFileTransformer::class)->toArray()['data'] ?? [],
            'tags' => fractal($product->tags, new UserProductTagTransformer($product))->toArray()['data'] ?? [],
            //'attributes' => $product->getAttrCollection($product->attributes, UserProductAttributeTransformer::class),
            'variants' => fractal($product->variants, VariantTransformer::class)->toArray()['data'] ?? [],
            'short_description' => $product->short_description,
            'description' => $product->description,
            'specification' => $product->specification,
            'children' => fractal($product->children, UserProductChildrenTransformer::class)->toArray()['data'] ?? [],
            'links' => [
                'show' => route('module.shop.api.web.products.show', [
                    'category' => $product->category->slug,
                    'product' => $product->slug
                ]),
            ],
            'web' => [
                'show' => route('module.shop.web.products.show', [
                    'category' => $product->category->slug,
                    'product' => $product->slug
                ]),
            ]
        ];
    }

    /**
     * Return the original attribute
     * @param mixed $index
     * @return string|null
     */
    public static function getOriginalAttributes($index)
    {
        $attributes = [
            'name',
            'slug',
            'stock',
            'price'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
