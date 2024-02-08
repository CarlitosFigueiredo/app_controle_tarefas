<?php

use App\Http\Controllers\TarefaController;
use App\Mail\MensagemTesteMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('bem-vindo');
});

Auth::routes(['verify' => true]);

Route::get('/tarefa/exportacao/{extensao}', [TarefaController::class, 'exportacao'])->name('tarefas.exportacao');

Route::get('/tarefa/exportar', [TarefaController::class, 'exportar'])->name('tarefas.exportar');

Route::resource('/tarefa', TarefaController::class)
    ->middleware('verified');

Route::get('/mensagem-teste', function () {
    return new MensagemTesteMail();
});
