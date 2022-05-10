<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function getAllUsers(Request $request)
    {
        $start = $request->get('start') !== null ? $request->get('start') : 0;
        $length = $request->get('length') !== null ? $request->get('length') : 50;
        $searchValue = $request->get('search')['value'] !== '' ? $request->get('search')['value'] : '';


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
            ->where('Sito_appartenenza','like', "%$searchValue%")
            ->orWhere('email','like', "%$searchValue%")
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
        } else {
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
            "role" => trim($request->get("role")),
            "name" => trim($request->get("username")),
            "email" => trim($request->get("email")),
            "genere" => trim(($genere)),
            "data_nascita" => $request->get("data_nascita"),
            "Attivo" => trim($request->get("Attivo")),
            "Sito_appartenenza" => trim($request->get("Sito_appartenenza")),
            "CF" => trim($request->get("CF")),
        ]);

        return "okay";
    }

    public function saveProfile(Request $request)
    {
        $user = DB::table('users')
            ->where('id', '=', Auth::user()->id);

        $genere = $request->get("genere") === 'male' ? 1 : 2;

        $user->update([
            "name" => trim($request->get("username")),
            "email" => trim($request->get("email")),
            "genere" => trim(($genere)),
            "data_nascita" => $request->get("data_nascita"),
            "CF" => trim($request->get("CF")),
        ]);

        return "okay";
    }

    public function existEmail(Request $request)
    {
        $email = DB::table('users')
            ->where('email', '=', trim($request->email))
            ->get();

        if(count($email) > 0){
            return "true";
        }

        return "false";
    }

    private function checkEmail($email)
    {
        $find1 = strpos($email, '@');
        $find2 = strpos($email, '.');
        return ($find1 !== false && $find2 !== false && $find2 > $find1);
    }

    public function addUser(Request $request)
    {
        $isValid = true;

        $username = trim($request->get("username"));
        $email = trim($request->get("email"));
        $CF = trim($request->get("CF"));

        if (!$this->checkEmail($email) || strlen($username) < 5 || strlen($CF) > 16 || strlen($CF) < 16) {
            return "errore nei campi di validazione";
        }


        DB::table('users')
            ->insert([
                "name" => $username,
                "email" => $email,
                "Sito_appartenenza" => trim($request->get("Sito_appartenenza")),
                "CF" => $CF,
                "role" => trim($request->get("role")),
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

    public function profile()
    {
        $pageConfigs = ['pageHeader' => false];

        $user = DB::table('users')
            ->where('id', '=', Auth::user()->id)
            ->get();

        $siti = DB::table('sito')
            ->where('Nome_sito', '=', Auth::user()->Sito_appartenenza)
            ->get();

        return view('/content/apps/user/app-user-profile', [
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