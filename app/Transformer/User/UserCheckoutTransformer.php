<?php

namespace Shop\App\Transformer\User;

use Shop\App\Transformer\User\UserOrderTransformer;
use Core\Transaction\Model\Checkout;
use Elyerr\ApiResponse\Assets\Asset;
use League\Fractal\TransformerAbstract;
use Core\Transaction\Transformer\User\UserTransactionTransformer;

class UserCheckoutTransformer extends TransformerAbstract
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
    public function transform(Checkout $checkout)
    {
        return [
            "id" => $checkout->id,
            "transaction_code" => $checkout->transaction_code,
            "transaction" => fractal($checkout->lastTransaction, UserTransactionTransformer::class)->toArray()['data'],
            "code" => $checkout->code,
            "delivery_address" => [
                "full_name" => $checkout->delivery_address['full_name'],
                "country" => $checkout->delivery_address['full_name'],
                "state" => $checkout->delivery_address['state'],
                "city" => $checkout->delivery_address['city'],
                "district" => $checkout->delivery_address['district'],
                "address" => $checkout->delivery_address['address'],
                "address_line_2" => $checkout->delivery_address['address_line_2'],
                "postal_code" => $checkout->delivery_address['postal_code'],
                "phone" => $checkout->delivery_address['phone'],
                "secondary_phone" => $checkout->delivery_address['secondary_phone'],
                "references" => $checkout->delivery_address['references'],
                "whatsapp" => "https://wa.me/" . preg_replace('/\D/', '', $checkout->delivery_address['phone']),
            ],
            "orders" => fractal($checkout->orders, UserOrderTransformer::class)->toArray()['data'],
            "created_at" => $this->format_date($checkout->created_at),
            "updated_at" => $this->format_date($checkout->updated_at),
            'links' => [
                'index' => route('module.shop.api.web.checkouts.index'),
            ],
            'web' => [
                'index' => route('module.shop.web.checkouts.index'),
                'show' => route('module.shop.web.checkouts.show', [
                    'checkout' => $checkout->id
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

        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
