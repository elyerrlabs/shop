<?php

namespace Shop\App\Transformer\User;


use League\Fractal\TransformerAbstract;
use Shop\App\Models\Icon;

class UserIconTransformer extends TransformerAbstract
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
    public function transform($icon)
    {
        return [
            'icon' => $icon->class,
            'origin' => $icon->origin
        ];
    }
}
