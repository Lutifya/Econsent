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
        $searchValue = $request->get('search')['value'] !== '' ? $request->get('search')['value'] : '';

        $dato = DB::table('sito')
            ->select([
                'id',
                'Nome_sito as full_name',
                DB::raw("'' as responsive_id"),
                'Nome_sito as username',
                'indirizzo_sito',
                'Attivo as status'])
            ->where('indirizzo_sito', 'like', "%$searchValue%")
            ->orWhere('Nome_sito', 'like', "%$searchValue%")
            ->offset($start)
            ->limit($length)
            ->get();

        $recordsTotal = DB::table('sito')
            ->count('id');

        return ["data" => $dato, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsTotal];
    }

    public function addSito(Request $request)
    {
        $isValid = true;

        $nome_sito = trim($request->get("nome_sito"));
        $indirizzo_sito = trim($request->get("indirizzo_sito"));
        $reazione1 = trim($request->get("reazione1"));
        $reazione2 = trim($request->get("reazione2"));

        if (strlen($nome_sito) < 2 || strlen($indirizzo_sito) < 3 || strlen($reazione1) < 3 || strlen($reazione2) < 3) {
            return "errore nei campi di validazione";
        }


        DB::table('sito')
            ->insert([
                "Nome_sito" => $nome_sito,
                "Indirizzo_sito" => $indirizzo_sito,
                "Reazione1" => $reazione1,
                "Reazione2" => $reazione2,
            ]);

        return "okay";
    }

    public function aggiungiDocumento(Request $request, $id)
    {
        $siti = DB::table('sito')
            ->where('id', '=', $id)
            ->get();

        if (count($siti) <= 0) {
            abort(404);
        }

        DB::table('documento_sito')
            ->insert([
                'id_sito' => $id,
                'id_documento' => $request->id_documento
            ]);

        return "okay";
    }


    public function aggiungiNuovoDocumento(Request $request, $id)
    {
        $siti = DB::table('sito')
            ->where('id', '=', $id)
            ->get();

        if (count($siti) <= 0 && $request->file('Contenuto') === null) {
            abort(404);
        }

        $hex = unpack("H*", file_get_contents($request->file('Contenuto')->getRealPath()));
        $hex = current($hex);

        $idDocumento = DB::table('documento')
            ->insertGetId([
                'Nome_documento' => $request->file('Contenuto')->getClientOriginalName(),
                'Data_inserimento' => now(),
                'contenuto' => $hex
            ]);

        DB::table('documento_sito')
            ->insert([
                'id_sito' => $id,
                'id_documento' => $idDocumento
            ]);

        return redirect('/siti/info/'.$id);
    }

    public function changeStateDocument(Request $request, $idSito)
    {
        $obj = DB::table('documento_sito')
            ->where('id_sito', '=', $idSito)
            ->where('id_documento', '=', $request->id_documento);

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

    public function siti_view($id)
    {
        $pageConfigs = ['pageHeader' => false];

        $sito = DB::table('sito')
            ->where('id', '=', $id)
            ->get();

//        $documenti = DB::table('documento')
//            ->leftJoin('documento_sito', 'documento.ID_documento', '=', 'documento_sito.id_documento')
//            ->where('documento_sito.id_documento', 'IS', NULL)
//            ->get();


        $documenti = DB::select(DB::raw("select * from documento where documento.ID_documento not in ("
            . "select documento.ID_documento from documento inner join documento_sito on documento.ID_documento = documento_sito.id_documento "
            . "where documento_sito.id_sito = :somevariable)"), array(
            'somevariable' => $id,
        ));


//        $results = DB::select( DB::raw("SELECT * FROM some_table WHERE some_col = :somevariable"), array(
//            'somevariable' => $someVariable,
//        ));


        if (count($sito) <= 0) {
            return "Not found";
        }

        return view('content.pages.siti-edit', [
            'pageConfigs' => $pageConfigs,
            'sito' => $sito[0],
            'documenti' => $documenti
        ]);
    }

    public function saveModify(Request $request, $id)
    {
        $sito = DB::table('sito')
            ->where('id', '=', $id);

        $check = $sito->get();

        if (count($check) <= 0) {
            return "Not found";
        }
        $sito->update([
            "indirizzo_sito" => trim($request->get("indirizzo_sito")),
            "Nome_sito" => trim($request->get("Nome_sito")),
            "Attivo" => trim($request->get("Attivo")),
        ]);

        return "okay";
    }

    public function getAllDocument(Request $request, $id)
    {

        $start = $request->get('start') !== null ? $request->get('start') : 0;
        $length = $request->get('length') !== null ? $request->get('length') : 50;
        $searchValue = $request->get('search')['value'] !== '' ? $request->get('search')['value'] : '';

        $dato = DB::table('documento_sito')
            ->select([
                'documento.ID_documento',
                'Nome_documento as full_name',
                DB::raw("'' as responsive_id"),
                'Data_inserimento as username',
                'Attivo as status'])
            ->join('documento', 'documento.ID_documento', 'documento_sito.id_documento')
            ->where('id_sito', '=', $id)
            ->where(function ($q) use ($searchValue) {
                $q->where('Nome_documento', 'like', "%$searchValue%");
            })
            ->offset($start)
            ->limit($length)
            ->get();

        $recordsTotal = DB::table('documento_sito')
            ->join('documento', 'documento.ID_documento', 'documento_sito.id_documento')
            ->count('*');

        return ["data" => $dato, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsTotal];

    }


    public function changeState(Request $request, $id)
    {
        $obj = DB::table('sito')
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

    public function existSiti(Request $request)
    {
        $email = DB::table('sito')
            ->where('Nome_sito', '=', trim($request->nome_sito))
            ->get();

        if (count($email) > 0) {
            return "true";
        }

        return "false";
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
