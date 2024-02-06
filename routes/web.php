<?php

use App\Http\Controllers\TarefaController;
use App\Mail\MensagemTesteMail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('bem-vindo');
});

Auth::routes(['verify' => true]);

Route::get('/tarefa/exportacao', [TarefaController::class, 'exportacao'])->name('tarefas.exportacao');

Route::resource('/tarefa', TarefaController::class)
    ->middleware('verified');

Route::get('/mensagem-teste', function () {
    return new MensagemTesteMail();
});
