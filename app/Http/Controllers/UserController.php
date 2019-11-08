<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function profile()
    {
          $typeUser =  auth()->user();

        if ($typeUser->email == 'admin@nti.com.br') {
            $users =   User::whereNotIn('email', ['admin@nti.com.br'])->get();

            return view('auth.index', compact('users'));
        } else {
            return view('perfil');
        }

        // return view('perfil');
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
    /**
     * Fazendo o Reset da Senha dos
     * Usuario da SEMUR
     * @param Request $request
     * @return void
     */
    public function resertUser($id)
    {
        $update = User::find($id);

        $update->update([
            'password'  =>  bcrypt('12345678'),
        ]);
        if ($update) {
            return redirect()
                ->back()
                ->with('success', 'A senha do Usuario foi Alterada para 12345678');
        }
        return redirect()->back()->with('error', 'Falhar ao atualizar perfil...');
    }   
  /**
     * Deltetando um Usuario da Area administrativa 
     *
     * @param [int] $id
     * @return void
     */
    public function delete(Request $request)
    {

        $delete  = User::find($request->id_user)->delete();

        if ($delete)
            return \redirect()->back()->with('success', 'Usuário deletado com sucesso!!');
        else
            return redirect()->back()->with('error', 'Falhar ao Deletar  Usuário');
    }


}
