<?php

namespace Shop\App\Transformer\Admin;

use App\Transformers\File\FileTransformer;
use Shop\App\Models\Product;
use Elyerr\ApiResponse\Assets\Asset;
use League\Fractal\TransformerAbstract;
use Shop\App\Transformer\Admin\CategoryTransformer;

class ProductTransformer extends TransformerAbstract
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
            'short_description' => $product->short_description,
            'description' => $product->description,
            'specification' => $product->specification,
            'category' => fractal($product->category, CategoryTransformer::class)->toArray()['data'],
            'images' => fractal($product->files, new FileTransformer($product->id))->toArray()['data'] ?? [],
            'tags' => fractal($product->tags, new ProductTagTransformer($product))->toArray()['data'] ?? [],
            'attributes' => fractal($product->attributes, new ProductAttributeTransformer($product))->toArray()['data'] ?? [],
            'variants' => fractal($product->variants, VariantTransformer::class)->toArray()['data'],
            'children' => fractal($product->children, new ProductChildrenTransformer($product))->toArray()['data'] ?? [],
            'links' => [
                'index' => route('module.shop.api.admin.products.index'),
                'store' => route('module.shop.api.admin.products.store'),
                'show' => route('module.shop.api.admin.products.show', ['product' => $product->id]),
                'destroy' => route('module.shop.api.admin.products.destroy', ['product' => $product->id]),
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
