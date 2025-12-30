<?php

namespace Shop\App\Services;

final class RouteService
{
    /**
     * Public API Web routes
     * @param array $routes
     * @return array 
     */
    public static function api(array $routes = [])
    {
        $defaults = [
            'search' => route('module.shop.api.web.search'),
            'categories' => route('module.shop.api.web.categories.index'),
            'filters' => route('module.shop.api.web.filters.index'),
            'checkouts' => route('module.shop.api.web.checkouts.index'),
            'orders' => route('module.shop.api.web.orders.index'),
            'payments' => route('module.shop.api.web.payments.store'),
        ];

        return array_merge($defaults, $routes);
    }

    /**
     * Admin
     * @return array
     */
    public static function admin()
    {
        return [
            'categories' => route('module.shop.api.admin.categories.store'),
            'orders' => route('module.shop.api.admin.orders.complete'),
            'customers' => route('module.shop.api.admin.orders.customers'),
            'pending' => route('module.shop.api.admin.orders.pending'),
            'products' => route('module.shop.api.admin.products.index')
        ];
    }
}
