<?php

namespace Shop\App\Transformer\User;

use League\Fractal\TransformerAbstract;

class UserProductAttributeTransformer extends TransformerAbstract
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
    public function transform(array $attribute)
    {
        return [
            'name' => ucfirst($attribute['name']),
            'slug' => strtolower($attribute['slug']),
            // 'type' => strtolower($attribute->type),
            'value' => $attribute['value'],
            //'widget' => strtolower($attribute->widget),
            //'multiple' => $attribute->multiple ? true : false,
            'stock' => $attribute['stock'],
            //'unit_id'
        ];
    }
}
