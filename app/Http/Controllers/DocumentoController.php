<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Documento;

class DocumentoController extends Controller
{
    public function index()
    {
        $documentos = Documento::all();
        $empresa = DB::table('equipamento')
            ->select('fornecedor')
            ->orderBy('fornecedor', 'asc')
            ->groupBy('fornecedor')
            ->get();

        return view('documentos.documento', compact('empresa', 'documentos'));
    }
    public function insert(Request $request)
    {
        $documento = new Documento();
        if ($request->hasFile('documento') && $request->file('documento')->isValid()) {
            # Define um nome aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            # Recupera a extensão do arquivo
            $extension = $request->documento->extension();
            # Define finalmente o nome
            $nameFile = "{$name}.{$extension}";
            # Faz o upload para uma pasta chamdas de arquivos:
            $upload = $request->documento->storeAs('arquivos', $nameFile);
            # Verifica se NÃO deu certo o upload (Redireciona de volta)
            if (!$upload) {
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload de arquivos')
                    ->withInput();
            } else {
                # Salvando registro no banco de dados.
                $documento->empresa = $request->empresa;
                // $documento->caminho = url('storage/arquivos/'.$nameFile);
                $documento->nome = $nameFile;
                $documento->descricao = $request->descricao;

                $documento->save();

                return redirect()
                    ->route('documento')
                    ->with('success', 'Documento salvo com sucesso!');
            }
        }
    }
}
