@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __($tarefa->tarefa) }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="card-body">
                        <fieldset disabled="disabled">
                            <div class="mb-3">
                                <label class="form-label">Data limite conclusão</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    name="data_limite_conclusao"
                                    value="{{$tarefa->data_limite_conclusao}}" />
                            </div>
                        </fieldset>
                        <a href="{{ route('tarefa.index') }}" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
