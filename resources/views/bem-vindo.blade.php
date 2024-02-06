Site de aplicação

@auth
    <h1>Usuário autenticado</h1>

    <p>ID {{ auth()->user()->id }}</p>
    <p>Nome {{ auth()->user()->name }}</p>
    <p>Email {{ auth()->user()->email }}</p>
@endauth

@guest
    Olá visitante, tudo bem?
    <br>...
    <br>...
@endguest
