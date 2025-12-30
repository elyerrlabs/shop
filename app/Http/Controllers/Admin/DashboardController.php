<?php

namespace Shop\App\Http\Controllers\Admin;



use Shop\App\Services\DashboardService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\WebController;

final class DashboardController extends WebController
{

    /**
     * DashboardService
     * @var DashboardService
     */
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        parent::__construct();
        $this->dashboardService = $dashboardService;
        $this->middleware('userCanAny:administrator:ecommerce:full, administrator:ecommerce:dashboard');
    }

    /**
     * Dashboard
     * @param \Illuminate\Http\Request $request
     * @return array|\Inertia\Response
     */
    public function dashboard(Request $request)
    {

        if ($request->wantsJson()) {
            return $this->dashboardService->dashboard($request);
        }
      
        return Inertia::render(
            'Admin/Dashboard/Index',
            [
                'routes' => [
                    'dashboard' => route('module.shop.admin.dashboard')
                ],
                'ecommerce_menus' => resolveInertiaRoutes(config('menus.shop_menus'))
            ]
        );
    }
}
