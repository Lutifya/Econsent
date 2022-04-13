<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){
        $pageConfigs = ['pageHeader' => false];
        $view = view('/content/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
        if(Auth::user()->role === 'user'){
            $view = view('/content/pages/DashboardUser', ['pageConfigs' => $pageConfigs]);
        }
        return $view;
    }

    // Dashboard - Analytics
    public function dashboardAnalytics()
    {
        $pageConfigs = ['pageHeader' => false];

        return view('/content/dashboard/dashboard-analytics', ['pageConfigs' => $pageConfigs]);
    }

    // Dashboard - Ecommerce
    public function dashboardEcommerce()
    {
        $pageConfigs = ['pageHeader' => false];

        return view('/content/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
    }
}
