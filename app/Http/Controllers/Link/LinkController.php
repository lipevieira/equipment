<?php

namespace App\Http\Controllers\Link;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Link\LinkFormRequest;
use App\Link;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::all();

        return view('links.index', compact('links'));
    }
    public function insertShow()
    {
        return view('links.insert');
    }

    public function store(LinkFormRequest $request)
    {
        $dataForm = $request->except('_token');

        $link = Link::create($dataForm);

        if ($link) {
            return redirect()->route('link.index')->with('success', 'Salvo com sucesso!');
        } else {
            return redirect()->route('link.index')->with('danger', 'Erro ao salvar!');
        }
    }
    public function show($id)
    {
        $link = Link::find($id);
        return view('links.update', compact('link'));
    }
    public function update(LinkFormRequest $request, $id)
    {
        $dataForm = $request->except('_token');

        $link = Link::find($request->id);
        $link->update($dataForm);

        return redirect()->route('link.index')
            ->with('success', 'Link alterado com sucesso!');
    }
   public function showDelete(Request $request)
    {
        $id = $request->id;

        $link = Link::find($id);
        return response()->json($link);
    }
    public function delete(Request $request)
    {
        $id = $request->id_excluir;
        
        Link::find($id)->delete();

        return redirect()->route('link.index')
            ->with('success', 'Link excluido com sucesso!');
    }
}
