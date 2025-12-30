<?php

namespace Shop\App\Transformer\User;

use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;

class UserFileTransformer extends TransformerAbstract
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
    public function transform($file)
    {
        return [
            'name' => $file->name,
            'url' => Storage::url($file->path),
        ];
    }
}
