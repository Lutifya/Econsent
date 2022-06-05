<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Psr\SimpleCache\InvalidArgumentException;

class DocumentiController extends Controller
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

        return view('content.pages.documenti', [
            'breadcrumbs' => $breadcrumbs,
            'header_dati' => $this->nomiCampi,
            'dati' => $datiTabella,
            'search' => $search
        ]);
    }

    public function getAllDocument(Request $request): array
    {
        $start = $request->get('start') !== null ? $request->get('start') : 0;
        $length = $request->get('length') !== null ? $request->get('length') : 50;
        $searchValue = $request->get('search')['value'] !== '' ? $request->get('search')['value'] : '';

        $dato = DB::table('documento')
            ->select([
                'documento.ID_documento',
                'Nome_documento as full_name',
                DB::raw("'' as responsive_id"),
                'Data_inserimento as username'])
            ->where('Nome_documento', 'like', "%$searchValue%")
            ->offset($start)
            ->limit($length)
            ->get();

        $recordsTotal = $recordsTotal = DB::table('documento')
            ->count('*');

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

    public function aggiungiDizionario(Request $request, $id)
    {
        $documento = DB::table('documento')
            ->where('ID_documento', '=', $id)
            ->get();

        if (count($documento) <= 0) {
            abort(404);
        }

        DB::table('dizionario_documento')
            ->insert([
                'id_documento' => $id,
                'id_dizionario' => $request->id_dizionario
            ]);

        return "okay";
    }

    public function aggiungiNuovoDocumento(Request $request)
    {
        if ($request->file('Contenuto') === null) {
            abort(404);
        }

        $hex = unpack("H*", file_get_contents($request->file('Contenuto')->getRealPath()));
        $hex = current($hex);

        $estensione = $request->file('Contenuto')->extension();
        DB::table('documento')
            ->insert([
                'Nome_documento' => $request->file('Contenuto')->getClientOriginalName(),
                'Data_inserimento' => now(),
                'Contenuto' => $hex,
                'Estensione' => $estensione
            ]);
        return redirect('/documenti');

    }

    private function file_get_contents_utf8($fn) {
        $content = file_get_contents($fn);
        return mb_convert_encoding($content, 'UTF-8',
            mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
    }

    public function aggiungiNuovoDizionario(Request $request, $id)
    {
        if ($request->file('Contenuto') === null) {
            abort(404);
        }

        $idDizionario = DB::table('dizionario')
            ->insertGetId([
                'Nome_dizionario' => $request->file('Contenuto')->getClientOriginalName(),
                'Data_inserimento' => now(),
                'contenuto' => $request->file('Contenuto')->getContent()
            ]);

        DB::table('dizionario_documento')
            ->insert([
                'id_dizionario' => $idDizionario,
                'id_documento' => $id
            ]);

        return redirect('/documenti/info/' . $id);
    }

    public function siti_view($id)
    {
        $pageConfigs = ['pageHeader' => false];

        $documento = DB::table('documento')
            ->where('ID_documento', '=', $id)
            ->get();

//        $documenti = DB::table('documento')
//            ->leftJoin('documento_sito', 'documento.ID_documento', '=', 'documento_sito.id_documento')
//            ->where('documento_sito.id_documento', 'IS', NULL)
//            ->get();


        $dizionari = DB::select(DB::raw("select * from dizionario where dizionario.ID_dizionario not in ("
            . "select dizionario.ID_dizionario from dizionario inner join dizionario_documento on dizionario.ID_dizionario = dizionario_documento.id_dizionario "
            . "where dizionario_documento.id_documento = :somevariable)"), array(
            'somevariable' => $id,
        ));


//        $results = DB::select( DB::raw("SELECT * FROM some_table WHERE some_col = :somevariable"), array(
//            'somevariable' => $someVariable,
//        ));


        if (count($documento) <= 0) {
            return "Not found";
        }

        return view('content.pages.documenti-edit', [
            'pageConfigs' => $pageConfigs,
            'documento' => $documento[0],
            'dizionari' => $dizionari
        ]);
    }

    public function saveModify(Request $request, $id)
    {
        $documento = DB::table('documento')
            ->where('ID_documento', '=', $id);

        $check = $documento->get();

        if (count($check) <= 0) {
            return "Not found";
        }
        $documento->update([
            "Nome_documento" => trim($request->get("nome_documento"))
        ]);

        return "okay";
    }


    public function getAllDizionari(Request $request, $id)
    {

        $start = $request->get('start') !== null ? $request->get('start') : 0;
        $length = $request->get('length') !== null ? $request->get('length') : 50;
        $searchValue = $request->get('search')['value'] !== '' ? $request->get('search')['value'] : '';

        $dato = DB::table('dizionario_documento')
            ->select([
                'dizionario.ID_dizionario as id',
                'Nome_dizionario as full_name',
                DB::raw("'' as responsive_id"),
                'Data_inserimento as username',
                'Attivo as status'])
            ->join('dizionario', 'dizionario.ID_dizionario', '=', 'dizionario_documento.id_dizionario')
            ->where('id_documento', '=', $id)
            ->where(function ($q) use ($searchValue) {
                $q->where('Nome_dizionario', 'like', "%$searchValue%");
            })
            ->offset($start)
            ->limit($length)
            ->get();

        $recordsTotal = DB::table('dizionario_documento')
            ->join('dizionario', 'dizionario.ID_dizionario', '=', 'dizionario_documento.id_dizionario')
            ->count('*');

        return ["data" => $dato, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsTotal];

    }


    public function changeState(Request $request, $id)
    {
        $obj = DB::table('dizionario_documento')
            ->where('id_documento', '=', $id)
            ->where('id_dizionario', '=', $request->id_dizionario);

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
