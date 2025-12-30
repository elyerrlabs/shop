<?php

namespace Shop\App\Transformer\User;

use Elyerr\ApiResponse\Assets\Asset;
use League\Fractal\TransformerAbstract;
use Shop\App\Transformer\User\UserFileTransformer;

class UserOrderTransformer extends TransformerAbstract
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
    public function transform($order)
    {
        return [
            'id' => $order->id,
            'meta' => $order->meta,
            'images' => fractal($order->orderable->variantable->files, UserFileTransformer::class)->toArray()['data'],
            'quantity' => $order->quantity,
            'stock' => $order->orderable->stock,
            'price' => $order->orderable->price->amount,
            'format_price' => $this->formatMoney($order->orderable->price->amount),
            'currency' => getCurrencySymbol($order->orderable->price->currency),
            'user_id' => [
                'id' => $order->user->id,
                'name' => $order->user->name . " " . $order->user->last_name,
                'email' => $order->email
            ],
            'status' => $order->status,
            'links' => [
                'show' => route('module.shop.api.web.products.show', [
                    'category' => $order->meta['category']['slug'],
                    'product' => $order['meta']['slug']
                ]),
                'update' => route('module.shop.api.web.orders.store'),
                'delete' => route('module.shop.api.web.orders.destroy', [
                    'order' => $order->id
                ])
            ],
            'web' => [
                'product' => route('module.shop.web.products.show', [
                    'category' => $order->meta['category']['slug'],
                    'product' => $order->meta['slug']
                ])
            ]
        ];
    }
}
