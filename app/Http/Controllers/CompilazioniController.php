<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompilazioniController extends Controller
{
    public function getALlCompilazioni(Request $request)
    {
//        columns[2][orderable
        $start = $request->get('start') !== null ? $request->get('start') : 0;
        $length = $request->get('length') !== null ? $request->get('length') : 50;
        $searchValue = $request->get('search')['value'] !== '' ? $request->get('search')['value'] : '';

        $dato = DB::table('compilazioni')
            ->select([
                'compilazioni.ID_compilazione',
                'documento.Nome_documento as full_name',
                DB::raw("'' as responsive_id"),
                'compilazioni.Data_compilazione as username',
            ])
            ->join('documento', 'documento.ID_documento', '=', 'compilazioni.id_documento')
            ->where('id_user', '=', Auth::user()->id)
            ->where(function ($e) use ($searchValue) {
                $e->where('documento.Nome_documento', 'like', "%$searchValue%");
//                    ->orWhere('email', 'like', "%$searchValue%");
            })
            ->offset($start)
            ->limit($length)
            ->orderBy('compilazioni.Data_compilazione','desc')
            ->get();

        $recordsTotal = count($dato);

        return ["data" => $dato, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsTotal];
    }


    public function displayPDF(Request $request, $id){

    }
}
