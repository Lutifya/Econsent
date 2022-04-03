<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller{

    public function getAllUsers(Request $request){
        $start = $request->get('start') !== null ? $request->get('start') : 0;
        $length = $request->get('length') !== null ? $request->get('length') : 50;

        $dato = DB::table('users')
            ->select([
                'id',
                'name as full_name',
                DB::raw("'' as responsive_id"),
                'name as username',
                'email',
                'role',
                'Sito_appartenenza as current_plan',
                'Attivo as status'])
            ->offset($start)
            ->limit($length)
            ->get();

        $recordsTotal = count($dato);

        return ["data" =>  $dato, 'recordsTotal' => $recordsTotal, 'recordsFiltered'=> $recordsTotal];
    }
    // User List Page
    public function user_list()
    {
        $pageConfigs = ['pageHeader' => false];

        $siti = DB::table('sito')->get();
        return view('/content/apps/user/app-user-list', ['pageConfigs' => $pageConfigs, 'siti' => $siti]);
    }

    // User View Page
    public function user_view()
    {
        $pageConfigs = ['pageHeader' => false];
        return view('/content/apps/user/app-user-view', ['pageConfigs' => $pageConfigs]);
    }

    // User Edit Page
    public function user_edit()
    {
        $pageConfigs = ['pageHeader' => false];
        return view('/content/apps/user/app-user-edit', ['pageConfigs' => $pageConfigs]);
    }
}