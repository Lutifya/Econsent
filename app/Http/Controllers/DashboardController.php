<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(){
        $pageConfigs = ['pageHeader' => false];

        $view = view('/content/pages/DashboardAdmin', ['pageConfigs' => $pageConfigs]);
        if(Auth::user()->role === 'utente'){

            $documenti = DB::table('documento')
                ->join('documento_sito', 'documento.ID_documento', '=', 'documento_sito.id_documento')
                ->join('sito', 'sito.id', '=', 'documento_sito.id_sito')
                ->where('sito.Nome_sito', '=', Auth::user()->Sito_appartenenza)
                ->where('documento_sito.Attivo', '=', '2')
                ->where('sito.Attivo', '=', '2')
                ->get();

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
