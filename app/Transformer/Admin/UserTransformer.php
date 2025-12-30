<?php


namespace Shop\App\Transformer\Admin;

use Core\User\Model\User;
use App\Repositories\Traits\Scopes;
use Elyerr\ApiResponse\Assets\Asset;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    use Asset;
    use Scopes;

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
    public function transform(User $user)
    {


        $transactions = $user->checkouts->flatMap->transactions;
        $transactionsByCurrency = $transactions
            ->groupBy('currency')
            ->map(function ($group, $currency) {
                return [
                    'currency' => strtoupper($currency),
                    'total' => $this->formatMoney($group->sum('total')),
                ];
            })
            ->values();

        return [
            "id" => $user->id,
            "name" => $user->name,
            "last_name" => $user->last_name,
            "email" => $user->email,
            "city" => $user->city,
            "address" => $user->address,
            "full_phone" => $user->dial_code . " " . $user->phone,
            "checkouts_count" => $user->checkouts->count(),
            "checkout" => $transactionsByCurrency
        ];
    }
}
