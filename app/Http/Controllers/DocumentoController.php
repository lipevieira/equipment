<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Documento;

class DocumentoController extends Controller
{
    public function index()
    {
        $doc = new Documento();
        $documentos = Documento::all();

        $empresa = $doc->getEmpresa();

        return view('documentos.documento', compact('empresa', 'documentos'));
    }
    public function insert(Request $request)
    {
        $documento = new Documento();
        $rules = $documento->rules();
        #validamdo formulario
        $this->validate($request, $rules);

        if ($request->hasFile('nome') && $request->file('nome')->isValid()) {
            # Define um nome aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            # Recupera a extensão do arquivo
            $extension = $request->nome->extension();
            # Define finalmente o nome
            $nameFile = "{$name}.{$extension}";
            # Faz o upload para uma pasta chamdas de arquivos:
            $upload = $request->nome->storeAs('arquivos', $nameFile);
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
    /***
     *@description: Recuperando uma registro do banco de dados
    @param mixed $id
    @return documento
     */
    public function showDocumento(Request $request)
    {
        $id = $request->id;
        $documento = Documento::find($id);

        return response()->json($documento);
    }
    /***
     * @description: Excluido um documento do banco de dados
     * e também do serivdor
     * @param mixed $idDeleteDocumento $nomeDocumento
     * @return messagem
     */
    public function deleteDocomento(Request $request)
    {
        $id = $request->idDeleteDocumento;
        $nome = $request->nomeDocumento;

        $resposta = Documento::find($id)->delete();
        if ($resposta) {
            Storage::delete("arquivos/{$nome}"); // true ou false

            return redirect()->route('documento')
                ->with('success', 'Documento excluido com sucesso!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Falha ao exluir documento!');
        }
    }
    public function filtro(Request $request, Documento $documento)
    {
        $doc = new Documento();
        $dateForm = $request->all();
        $empresa = $doc->getEmpresa();
        $documentos = $documento->search($dateForm);

        return view('documentos.documento', compact('documentos', 'empresa'));
    }
    public function updateDocumento(Request $request)
    {
        $dataForm = $request->except('_token');
  
        // Verificando se enviou arquivo.
        if ($request->hasFile('nome') && $request->file('nome')->isValid()) {

            # Define um nome aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
            # Recupera a extensão do arquivo
            $extension = $request->nome->extension();
            # Define finalmente o nome
            $nameFile = "{$name}.{$extension}";
            # Faz o upload para uma pasta chamdas de arquivos:
            $upload = $request->nome->storeAs('arquivos', $nameFile);

            $dataForm['nome'] = $nameFile;
            
            # Verifica se NÃO deu certo o upload (Redireciona de volta)
            if (!$upload) {
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload de arquivos')
                    ->withInput();
            }
        }
        # Salvando registro no banco de dados.
        $documento = Documento::find($request->idEdit);
        $documento->update($dataForm);

        return redirect()->route('documento')
            ->with('success', 'Documento alterado com sucesso!');
    }
     public function download(Request $request)
    {
        $nome = $request->nome;
        return response()->download(storage_path("app/public/arquivos/".$nome));
        // return response()->download($pathToFile);
    }

}
