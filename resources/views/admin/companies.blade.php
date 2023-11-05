@extends('layouts.system')

@section('title', 'Empresas')

@section('content')

<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mt-3 mx-3">
        <h1 class="m-0">Lista de Empresas</h1>
    </div>
    <hr>
    <div class="d-flex align-items-center justify-content-between mt-0 mx-3 flex-wrap">
      <form class="d-flex justify-content-between align-items-center form-control p-0 m-0 w-auto form-search" id="form-search" method="GET" action="{{ route('companies') }}">
        @csrf
        <input class="m-0 p-2" id="input-search" type="search" placeholder="Faça uma busca" aria-label="Faça uma busca" name="name" value="{{ old('name') }}">
        <button class="m-0 p-2" type="submit">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 20 20">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg>
      </button>
    </form>
    </div>
    <hr>
    {{-- Listagem aqui --}}
    <div class="table-responsive">
      <table class="table table-striped table-sm">
          <thead>
          <tr>
              <th scope="col">Nome</th>
              <th scope="col">Email</th>
              <th scope="col">Nº Notícias</th>
              <th scope="col">Ações</th>
          </tr>
          </thead>
          <tbody>
          <tr>

            
            @foreach($companies as $user)

              <td>{{ $user->name}}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->news->count()}}</td>
              <td>
                <div class="d-flex align-items-center">
                  {{-- Botão Switch Empresa/Visitante --}}
                  <form action="{{route('companies.switch',$user)}}" method="post" class="me-1">
                    @csrf
                    @method("PUT")
    
                    <button type="submit" class="btn btn-sm btn-success text-decoration-none btn-space">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                        <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                        <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                      </svg>
                    </button>
                  </form>
                  {{-- Botão de excluir --}}
                  <form action="{{route('companies.destroy',$user)}}" method="post">
                  @csrf
                  @method("DELETE")

                  <button type="button" onclick="confirmDeleteModal(this)" class="btn btn-sm btn-danger btn-space">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                      <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
          </tbody>
      </table>
      {{ $companies->links() }}
    </div>
</div>


@endsection