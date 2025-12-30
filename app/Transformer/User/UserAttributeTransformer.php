<?php

namespace Shop\App\Transformer\User;
 
use League\Fractal\TransformerAbstract;

class UserAttributeTransformer extends TransformerAbstract
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
    public function transform($attribute)
    {
        return [
            "name" => $attribute['name'],
            "slug" => $attribute['slug'],
            "type" => $attribute['type'],
            "widget" => $attribute['widget'],
            "multiple" => $attribute['multiple'],
            //      "unit_id" => $attribute['unit_id'],
            "values" => $attribute['values']
        ];
    }
}
