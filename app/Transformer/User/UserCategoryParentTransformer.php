<?php

namespace Shop\App\Transformer\User;

use League\Fractal\TransformerAbstract;
use Shop\App\Models\Category;
use Shop\App\Transformer\User\UserFileTransformer;

class UserCategoryParentTransformer extends TransformerAbstract
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
    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
            'featured' => $category->featured ? true : false,
            'published' => $category->published ? true : false,
            'icon' => fractal($category->icon, UserIconTransformer::class)->toArray()['data'] ?? [],
            'images' => fractal($category->files, UserFileTransformer::class)->toArray()['data'] ?? [],
            'links' => [
                'index' => route('module.shop.api.web.category.show', [
                    'category' => $category->slug
                ]),
            ],
            'web' => [
                'index' => route('module.shop.web.category', [
                    'category' => $category->slug
                ]),
            ]
        ];
    }
}
