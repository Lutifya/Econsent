<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(){
        $pageConfigs = ['pageHeader' => false];

        $documenti = DB::table('documento')
            ->join('documento_sito', 'documento.ID_documento', '=', 'documento_sito.id_documento')
            ->join('sito', 'sito.id', '=', 'documento_sito.id_sito')
            ->where('sito.Nome_sito', '=', Auth::user()->Sito_appartenenza)
            ->get();

        $view = view('/content/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
        if(Auth::user()->role === 'user'){
            $view = view('/content/pages/DashboardUser', [
                'pageConfigs' => $pageConfigs,
                'documenti' => $documenti,
            ]);
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
