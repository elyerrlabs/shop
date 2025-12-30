<?php

namespace Shop\App\Transformer\Admin;

use Elyerr\ApiResponse\Assets\Asset;
use League\Fractal\TransformerAbstract;

class TotalTransformer extends TransformerAbstract
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
    public function transform($total)
    {
        return [
            'total' => $total['total'],
            'date' => $total['range'] ?? null,
        ];
    }
}