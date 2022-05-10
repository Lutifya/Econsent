<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BuilderController extends Controller
{

    public function index(Request $request, $id, $education)
    {
        $document = DB::table('documento')
            ->where('ID_documento', '=', $id)
            ->get();

        $dizionari = DB::table('dizionario_documento')
            ->where('id_documento', '=', $id)
            ->get();

        if (count($document) <= 0) {
            return abort(404);
        }

        return view('content.pages.builder', [
            'documento' => $document[0],
            'idDocumento' => $id,
            'Estensione' => $document[0]->Estensione,
            'numEdu' => $education
        ]);
    }

    public function getDoc(Request $request, $id){
        $documento = DB::table('documento')
            ->where('ID_documento', '=', $id)
            ->get();

        if(count($documento) <= 0){
            abort(404);
        }

        $documento = $documento[0];

        $hex = pack("H*", $documento->Contenuto);

        $doc = preg_replace('/[^A-Za-z0-9ÄäÜüÖöß$ \/),.<è>\/ò@_à\n]/', ' ', $hex);
        $doc = preg_replace('/[\n]/', '\n', $doc);
//        bin2hex(file_get_contents($request->file('Contenuto')->getRealPath()))

        return $doc;
    }

    public function getDizionari(Request $request, $id){
        return DB::table('dizionario')
            ->join('dizionario_documento', 'dizionario_documento.id_dizionario', '=', 'dizionario.ID_dizionario')
            ->where('dizionario_documento.id_documento', '=', $id)
            ->get();
    }

    public function saveDocument(Request $request, $id){
        //check se ci sono tutti i dati

        $moduloCompilato = isset($request->modulo) ? json_decode($request->modulo) : null;

        if ($moduloCompilato === null) {
            echo "Chiamata effettuata in modo non corretto";
            exit();
        }

        $compilazioni = array();


        $compilazioni['footer'] = $moduloCompilato->footer;
        $compilazioni['id_user'] = Auth::user()->id;
        $compilazioni['id_documento'] = $id;
        $idCompilazione = DB::table('compilazioni')->insertGetId($compilazioni);

        foreach ($moduloCompilato->title as $title) {
            $array = [];
            $array['titolo'] = $title;
            $array['id_compilazione'] = $idCompilazione;
            DB::table('titoli_documento')->insert($array);
        }

        foreach ($moduloCompilato->sections as $section) {
            $temp = array();
            $temp['title'] = $section->title;
            $idParagrafo = DB::table('sections')->insertGetId($temp);

            foreach ($section->paragraphs as $paragraph) {
                $temp = array();
                $temp['id_section'] = $idParagrafo;
                $temp['id_compilazione'] = $idCompilazione;
                $temp['testo'] = $paragraph->text;
                DB::table('paragraph')->insert($temp);
            }

        }
        echo json_encode(['idCompilazione' => $idCompilazione]);
    }
}
