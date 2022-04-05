<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function getAllUsers(Request $request)
    {
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

        return ["data" => $dato, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsTotal];
    }

    public function changeState(Request $request, $id)
    {
        $obj = DB::table('users')
            ->where('id', '=', $id);

        $update = clone($obj);
        $obj = $obj->get();

        if (count($obj) <= 0) {
            return "Not found";
        }
        else{
            $valore = $obj[0]->Attivo === 2 ? 3 : 2;
            $update->update([
                'Attivo' => $valore
            ]);
        }
        return "okay";
    }


    // User List Page
    public function user_list()
    {
        $pageConfigs = ['pageHeader' => false];

        $siti = DB::table('sito')->get();
        return view('/content/apps/user/app-user-list', ['pageConfigs' => $pageConfigs, 'siti' => $siti]);
    }

    public function saveModify(Request $request, $id)
    {
        $user = DB::table('users')
            ->where('id', '=', $id);

        $check = $user->get();

        if (count($check) <= 0) {
            return "Not found";
        }
        $genere = $request->get("genere") === 'male' ? 1 : 2;
        $user->update([
            "name" => $request->get("username"),
            "email" => $request->get("email"),
            "role" => $request->get("role"),
            "genere" => $genere,
            "data_nascita" => $request->get("data_nascita"),
            "Attivo" => $request->get("Attivo"),
            "Sito_appartenenza" => $request->get("Sito_appartenenza"),
            "CF" => $request->get("CF"),
        ]);

        return "okay";
    }

    public function saveProfile(Request $request)
    {
        $user = DB::table('users')
            ->where('id', '=', Auth::user()->id);

        $genere = $request->get("genere") === 'male' ? 1 : 2;

        $user->update([
            "name" => $request->get("username"),
            "email" => $request->get("email"),
            "role" => $request->get("role"),
            "genere" => $genere,
            "data_nascita" => $request->get("data_nascita"),
            "Attivo" => $request->get("Attivo"),
            "Sito_appartenenza" => $request->get("Sito_appartenenza"),
            "CF" => $request->get("CF"),
        ]);

        return "okay";
    }

    // User View Page
    public function user_view($id)
    {
        $pageConfigs = ['pageHeader' => false];

        $user = DB::table('users')
            ->where('id', '=', $id)
            ->get();

        $siti = DB::table('sito')
            ->get();

        if (count($user) <= 0) {
            return "Not found";
        }

        return view('/content/apps/user/app-user-edit', [
            'pageConfigs' => $pageConfigs,
            'user' => $user[0],
            'siti' => $siti,
        ]);
    }

    // User Edit Page
    public function user_edit()
    {
        $pageConfigs = ['pageHeader' => false];
        return view('/content/apps/user/app-user-edit', ['pageConfigs' => $pageConfigs]);
    }
}