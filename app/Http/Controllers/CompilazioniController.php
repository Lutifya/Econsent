<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

include_once('PhpWord/TemplateProcessor.php');
include_once('PhpWord/Settings.php');
include_once('PhpWord/Shared/ZipArchive.php');

use League\Flysystem\Exception;
use PhpWord\TemplateProcessor;

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


    /**
     * @throws \PhpWord\Exception\CopyFileException
     * @throws \PhpWord\Exception\CreateTemporaryFileException
     */
    public function displayPDF(Request $request, $id){
        $code = sha1($id . time());
//        $name = 'Consenso Informato_'.$code;
        $name = $code;

        $file = './Document/Consenso Informato.docx';

//        $fileNew = "./Document/Consenso Informato_$name.docx";
        $fileNew = "./Document/$name.docx";
        $phpword = new TemplateProcessor($file);

        $blockName = $phpword->copyBlock('blockName');
        $blockTitle = $phpword->copyBlock('blockTitle');

        $resultCompilazione = DB::table('compilazioni')
            ->where('ID_compilazione', '=', $id)
            ->get()[0];

        $titoliDocumento = DB::table('titoli_documento')
            ->where('id_compilazione', '=', $id)
            ->get();

        foreach ($titoliDocumento as $titolo){
            $phpword->pasteBlock('blockHeader', $blockTitle, true, ["title" => $titolo->titolo]);
        }

        $phpword->pasteBlock('blockHeader', $blockTitle, true, ["title" => $resultCompilazione->footer]);


        $paragrafi = DB::table('paragraph')
            ->where('id_compilazione', '=', $id)
            ->get();

        foreach($paragrafi as $paragrafo){
            $testo = preg_replace('/(__|__$)/m', '', $paragrafo->testo);
            $phpword->pasteBlock('blockMaster', $blockName, true, ["text" => $testo]);
        }

        $phpword->ripulisci('blockMaster');
        $phpword->ripulisci('blockHeader');

        $phpword->saveAs($fileNew);

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //per windows
            shell_exec("python ./Document/prova.py $name");
        } else {
            //per linux
            $out =  "";
            shell_exec("unoconv -f pdf $fileNew", $out);
            var_dump($out);

        }


        $filePDF = "./Document/$name.pdf";
        try{
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="Modulo di Consenso.pdf"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($filePDF));
            header('Accept-Ranges: bytes');
            @readfile($filePDF);

            unlink($filePDF);
            unlink($fileNew);

        }catch (Exception $exception){
            //Ripulire i file
            unlink($fileNew);
        }


    }
}
