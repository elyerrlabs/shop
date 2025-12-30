<?php
/**
 * This file is part of the Elymod package.
 *
 * It defines shared menu configuration for the identity system.
 * Menus declared here can be merged and consumed by core, system,
 * and third-party modules.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Shared Menu Definitions
    |--------------------------------------------------------------------------
    |
    | Menus defined under the "merge" key are automatically shared across
    | the application. Each menu entry must follow a consistent structure
    | so it can be rendered correctly by the UI layer.
    |
    | Required fields:
    | - id:      Unique menu identifier
    | - name:    Display name
    | - route:   Named route
    | - icon:    Material Design icon (mdi-* webfont)
    | - service: Access scope in the format "group:service"
    |
    */


    "shop_orders" => [
        "id" => "orders",
        "name" => "My cart",
        "route" => "module.shop.web.orders.index",
        "icon" => "mdi-store-cog",
        'service' => true
    ],

    "shop_dashboard" => [
        "id" => "search",
        "name" => "Search",
        "route" => "module.shop.web.search",
        "icon" => "mdi-shopping-search-outline",
        'service' => true
    ],

    "shop_checkout" => [
        "id" => "orders",
        "name" => "My checkouts",
        "route" => "module.shop.web.checkouts.index",
        "icon" => "mdi-shopping-search-outline",
        'service' => true
    ],

    'merge' => [

        /*
        |----------------------------------------------------------------------
        | Admin Dashboard Menu
        |----------------------------------------------------------------------
        |
        | Menu items displayed in the administrative dashboard.
        | Intended for system administrators and privileged users.
        |
        */
        'admin_dashboard' => [

            "shop" => [
                "id" => "shop",
                "name" => "Shop",
                "route" => "module.shop.admin.dashboard",
                "icon" => "mdi-store-cog",
                'service' => "administrator:ecommerce"
            ],

        ],

        /*
        |----------------------------------------------------------------------
        | User Application Menu
        |----------------------------------------------------------------------
        |
        | Routes displayed in the main application menu for authenticated users.
        |
        */
        'user_routes' => [


            "shop" => [
                "id" => "shop",
                "name" => "My Store",
                "route" => "module.shop.web.dashboard",
                "icon" => "mdi-store-cog",
                'service' => true
            ],

            "shop_orders" => [
                "id" => "orders",
                "name" => "My cart",
                "route" => "module.shop.web.orders.index",
                "icon" => "mdi-store-cog",
                'service' => true
            ],

            "shop_checkout" => [
                "id" => "orders",
                "name" => "My orders",
                "route" => "module.shop.web.checkouts.index",
                "icon" => "mdi-store-cog",
                'service' => true
            ],

        ],

        /*
        |----------------------------------------------------------------------
        | Admin Applications (User Accessible)
        |----------------------------------------------------------------------
        |
        | Administrative applications that a user may access depending on
        | granted permissions or service scopes.
        |
        | These entries are typically shown in admin application sections
        | rather than global dashboards.
        |
        */
        'admin_routes' => [
            /*
            'elymod-admin-app' => [
                'id'      => 'elymod-app',
                'name'    => 'ElyMod',
                'route'   => 'module.elymod.web.welcome',
                'icon'    => 'mdi-application',
                'service' => 'user:access',
            ],
            */
        ],

        /*
        |----------------------------------------------------------------------
        | User Settings Menu
        |----------------------------------------------------------------------
        |
        | Menu entries displayed under the user settings section.
        |
        */
        'user_settings' => [

            /*
            'elymod-settings' => [
                'id'      => 'elymod-settings',
                'name'    => 'ElyMod Settings',
                'route'   => 'module.elymod.web.settings',
                'icon'    => 'mdi-cog',
                'service' => 'user:settings',
            ],
            */

        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Module-Specific Admin Routes
    |--------------------------------------------------------------------------
    |
    | Allows injecting additional menu entries into a specific module’s
    | administrative area.
    |
    | The key used here must match the target module key.
    | Each route definition must follow the same structure as shared menus.
    |
    */

    'admin_routes' => [
        /*
        [
            'id' => 'elymod',
            'name' => 'ElyMod',
            'route' => 'module.elymod.web.welcome',
            'icon' => 'mdi-store-cog',
            'service' => true,
            'position' => 8,
        ],
        */
    ],

    "shop_menus" => [
        [
            "id" => 'dashboard',
            "name" => "Dashboard",
            "route" => "module.shop.admin.dashboard",
            "icon" => "mdi-view-dashboard",
            'service' => "administrator:ecommerce"
        ],
        [
            "id" => "categories",
            "name" => "Categories",
            "route" => "module.shop.admin.categories.index",
            "icon" => "mdi-circle-outline",
            'service' => "administrator:ecommerce"
        ],
        [
            "id" => "products",
            "name" => "Products",
            "route" => "module.shop.admin.products.index",
            "icon" => "mdi-circle-outline",
            'service' => "administrator:ecommerce"
        ],
        [
            "id" => "orders",
            "name" => "Orders",
            "route" => "module.shop.admin.orders.complete",
            "icon" => "mdi-format-list-checks",
            'service' => "administrator:ecommerce"
        ],
        [
            "id" => "orders_pending",
            "name" => "Pending",
            "route" => "module.shop.admin.orders.pending",
            "icon" => "mdi-clock-outline",
            'service' => "administrator:ecommerce"
        ],
        [
            "id" => "orders_customers",
            "name" => "Customers",
            "route" => "module.shop.admin.orders.customers",
            "icon" => "mdi-account-group",
            'service' => "administrator:ecommerce"
        ],
    ],


];
