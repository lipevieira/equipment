<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return view('auth/login');
});

Auth::routes();

Route::get('perfil', 'UserController@profile')->name('perfil');

Route::post('perfil/update-user', 'UserController@updateUser')->name('update-user');

Route::post('addEquipamento', 'HomeController@insert')->name('insert');

Route::post('updateEquipamento', 'HomeController@update')->name('update');

Route::post('deleteEquipamento', 'HomeController@delete')->name('delete');

Route::post('showEquipamento', 'HomeController@showEquipamento')->name('showEquipamento');

Route::post('addEmprestimo', 'EmprestimoController@insertEmprestimo')->name('addEmprestimo');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/equipamento', 'HomeController@equipamentoAll')->name('equipamentoAll');

Route::get('/home/saida', 'EmprestimoController@reciboSaidaEquipamento')->name('saida');

Route::get('/emprestimo', 'EmprestimoController@index')->name('index');

    Route::post('/showEquipamentoEmprestimo', 'EmprestimoController@showEquipamentoEmprestimo')->name('showEquipamentoEmprestimo');

    Route::get('/emprestimoAll', 'EmprestimoController@emprestimoAll')->name('emprestimoAll');

    Route::post('updateEmprestimo', 'EmprestimoController@update')->name('updateEmprestimo');

    Route::post('devolver', 'EmprestimoController@devolver')->name('devolver');

    Route::get('emprestimo/segundaVia/{id}', 'EmprestimoController@segundaViaSaidaEquipamento')->name('segundaVia');

    Route::get('emprestimo/recibo/devolucao/{id}', 'EmprestimoController@reciboDelucaoEquipamento')->name('reciboDevolucao');

// ROTAS PARA DOCUMENTOS
Route::get('/documento', 'DocumentoController@index')->name('documento');
    Route::post('documento/insert', 'DocumentoController@insert')->name('insertDocumento');
    Route::get('documento/mostar/documento', 'DocumentoController@showDocumento')->name('showDocumento');
    Route::post('documento/delete', 'DocumentoController@deleteDocomento')->name('deleteDocomento');