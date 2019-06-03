<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function profile()
    {
        return view('perfil');
    }
    public function updateUser(Request $request)
    {
        $data = $request->all();

        if ($data['password'] != null) 
            $data['password'] = bcrypt($data['password']);
         else 
            unset($data['password']);
        
        $update = auth()->user()->update($data);

        if ($update) 
            return redirect()->route('perfil')
                ->with('success', 'Atualizado com sucesso!');
        

        return redirect()->back()->with('error', 'Falhar ao atualizar perfil...');
    }
}
