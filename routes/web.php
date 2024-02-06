<?php

use App\Http\Controllers\TarefaController;
use App\Mail\MensagemTesteMail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
//     ->name('home')
//     ->middleware('verified');

Route::resource('/tarefa', TarefaController::class)
    ->middleware('verified');

Route::get('/mensagem-teste', function () {

    // Ver o modelo do e-mail
    return new MensagemTesteMail();

    // Enviar um e-mail para teste...
    // Mail::to('medeirosfigueiredoc@gmail.com')->send(new MensagemTesteMail());
    // return 'E-mail enviado com sucesso!';
});
