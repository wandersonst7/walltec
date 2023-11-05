@extends ('layouts.system')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mt-3 mx-3">
        <h1 class="m-0">Lista de Notícias</h1>
        <a class="btn btn-success" href="{{ route('news.create') }}">Nova</a>
    </div>
    <hr>
    <div class="d-flex align-items-center justify-content-between mt-0 mx-3 flex-wrap">
        <form class="d-flex justify-content-between align-items-center form-control p-0 m-0 w-auto form-search" id="form-search" method="GET" action="{{ route('dashboard') }}">
            @csrf
            <input class="m-0 p-2" id="input-search" type="search" placeholder="Faça uma busca" aria-label="Faça uma busca" name="title" value="{{ old('title') }}">
            <button class="m-0 p-2" type="submit">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 20 20">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
          </button>
        </form>
    </div>
    <hr>
    
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">Titulo</th>
                <th scope="col">Autor</th>
                <th scope="col">Data</th>
                <th scope="col">Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr>

              
              @foreach($data as $news)
                @if(Auth::user()->id == $news->user_id || Auth::user()->level == $admin_user)
                  <td>{{ $news->title }}</td>
                  <td>{{ isset($news->user->name) ? $news->user->name : "Empresa Id: " . $news->user_id}}</td>
                  <td>{{ $news->created_at->format('d/m/Y')}}</td>
                  <td>

                  <div class="d-flex align-items-center buttons-dashboard">
                    <a href="{{ route('news.open', $news->slug )}}" class="btn btn-sm btn-success text-decoration-none btn-space">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
                        <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
                      </svg>
                    </a>

                    @can('delete', $news)
                      <a href="{{route("news.edit",$news)}}" class="btn btn-sm btn-primary text-decoration-none btn-space">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                          <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                          <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                      </a>
                    @endcan  

                @can('delete', $news)
                    <form action="{{route('news.destroy',$news)}}" method="post" >
                    @csrf
                    @method("DELETE")
                    
                      <button type="button" onclick="confirmDeleteModal(this)" class="btn btn-sm btn-danger btn-space">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                          <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                          <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                      </button>
                  
                    </form>
                @endcan
                  </div>
                </td>
              @endif
            </tr>
            @endforeach
            </tbody>
        </table>
         {{$data->links()}}
    </div>

</div>

@endsection