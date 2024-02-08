<?php

namespace App\Http\Controllers;

use App\Exports\TarefasExpert;
use App\Mail\NovaTarefaMail;
use App\Models\Tarefa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class TarefaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $tarefas = Tarefa::where('user_id', $user_id)->paginate(10);
        return view('tarefa.index', ['tarefas' => $tarefas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->all(['tarefa', 'data_limite_conclusao']);
        $dados['user_id'] = auth()->user()->id;

        $tarefa = Tarefa::create($dados);

        $destinatario = auth()->user()->email;
        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));

        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarefa $tarefa)
    {
        return view('tarefa.show', compact('tarefa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;

        if ($tarefa->user_id === $user_id) {

            return view('tarefa.edit', ['tarefa' => $tarefa]);
        }

        return view('acesso-negado');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        if (!$tarefa->user_id === auth()->user()->id) {
            return view('acesso-negado');
        }

        $tarefa->update($request->all());
        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarefa $tarefa)
    {
        if (!$tarefa->user_id === auth()->user()->id) {
            return view('acesso-negado');
        }

        $tarefa->delete();
        return to_route('tarefa.index');
    }

    /**
     * Export excel
     */
    public function exportacao(string $extensao)
    {
        if (in_array($extensao, ['xlsx', 'csv', 'pdf'])) {

            return Excel::download(new TarefasExpert, 'lista_de_tarefas.' . $extensao);
        }

        return to_route('tarefa.index');
    }

    /**
     * Export PDF Via barryvdh / laravel-dompdf
     */
    public function exportar()
    {
        $tarefas = auth()->user()->tarefas()->get();
        $pdf = Pdf::loadView('tarefa.pdf', ['tarefas' => $tarefas]);

        $pdf->setPaper('a4', 'portrait');
        //tipo de papel: a4, letter
        //orientação: landscape (paisagem), portrait (retrato)

        // return $pdf->download('lista_de_tarefas.pdf'); //Download...

        return $pdf->stream('lista_de_tarefas.pdf'); //View...
    }
}
