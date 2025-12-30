<?php

namespace Shop\App\Transformer\Admin;

use App\Transformers\File\FileTransformer;
use Shop\App\Models\Category;
use Shop\App\Transformer\User\UserIconTransformer;
use League\Fractal\TransformerAbstract;

class CategoryChildrenTransformer extends TransformerAbstract
{
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
    public function transform($category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
            'featured' => $category->featured ? true : false,
            'published' => $category->published ? true : false,
            'icon' => fractal($category->icon, UserIconTransformer::class)->toArray()['data'] ?? [],
            'images' => fractal($category->files, new FileTransformer($category->id))->toArray()['data'] ?? [],
            'children' => fractal($category->children, CategoryChildrenTransformer::class)->toArray()['data'] ?? [],
            'links' => [
                'index' => route('module.shop.api.admin.categories.index'),
                'store' => route('module.shop.api.admin.categories.store'),
                'show' => route('module.shop.api.admin.categories.show', ['category' => $category->id]),
                'destroy' => route('module.shop.api.admin.categories.destroy', ['category' => $category->id]),
            ]
        ];
    }
}
