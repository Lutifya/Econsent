<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Psr\SimpleCache\InvalidArgumentException;

class SitiController extends Controller
{
    //Nomi dei campi da visualizzare a colpo d'occhio in pagina
    private array $nomiCampi = [
        'indirizzo_sito',
        'Nome_sito',
        'Reazione1',
        'Reazione2'
    ];

    public function index()
    {

        $breadcrumbs = [];
        $datiTabella = [];
        $search = "";
        if (isset($request->search)) {
            $datiTabella = DB::table('sito')
                ->select($this->nomiCampi)
                ->where('Nome_sito', 'like', '%' . $request->search . '%')
                ->paginate(4);
            $search = "&search=" . $request->search;
        } else {
            try {
                $datiTabella = DB::table('sito')
                    ->select($this->nomiCampi)
                    ->paginate(10);
            } catch (InvalidArgumentException $e) {
            }
        }

        return view('content.pages.siti', [
            'breadcrumbs' => $breadcrumbs,
            'header_dati' => $this->nomiCampi,
            'dati' => $datiTabella,
            'search' => $search
        ]);
    }

    public function getAllSiti(Request $request): array
    {
        $start = $request->get('start') !== null ? $request->get('start') : 0;
        $length = $request->get('length') !== null ? $request->get('length') : 50;
        $searchValue = $request->get('search[value]') !== null ? $request->get('search[value]') : '';

        $dato = DB::table('sito')
            ->select([
                'id',
                'Nome_sito as full_name',
                DB::raw("'' as responsive_id"),
                'Nome_sito as username',
                'indirizzo_sito',
                'Attivo as status'])
            ->where('indirizzo_sito','like', "%$searchValue%")
            ->orWhere('Nome_sito','like', "%$searchValue%")
            ->offset($start)
            ->limit($length)
            ->get();

        $recordsTotal = count($dato);

        return ["data" => $dato, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsTotal];
    }


    public function viewData(Request $request)
    {
        $dato = [];
        $documenti = [];
        $documenti_sito = [];

        try {
            $dato = DB::table('sito')
                ->where('indirizzo_sito', '=', $request->input('codice'))
                ->limit(1)->get();

            $documenti_sito = DB::table('documento')
                ->join('documento_sito', 'documento.ID_documento', '=', 'documento_sito.id_documento')
                ->get();

            $documenti = DB::table('documento')
                ->get();

        } catch (\Exception $exception) {
            abort(406);
        }

        return ['dato' => $dato, 'documenti_sito' => $documenti_sito, 'documenti' => $documenti];
    }
}
