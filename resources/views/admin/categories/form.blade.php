@extends ('layouts.system')

@if ($data->id == "")
    @section('title', 'Criar Categoria')
@else
    @section('title', 'Atualizar Categoria')
@endif

@section('content')

<div class="container-fluid">
    @if ($data->id == "")

    <div class="d-flex align-items-center justify-content-between mt-3 mx-3">
        <h1 class="m-0">Criar Nova Categoria</h1>
    </div>
    <hr>
    <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">

    @else

    <div class="d-flex align-items-center justify-content-between mt-3 mx-3">
        <h1 class="m-0">Atualizar Categoria</h1>
    </div>
    <hr>
    <form method="POST" action="{{ route('categories.update',$data) }}" enctype="multipart/form-data">
    @method('PUT')
    @endif

    @csrf

    <div class="row mb-3">
        <label for="name_category" class="col-md-4 col-form-label text-md-end">{{ __('name_category') }}</label>

        <div class="col-md-6">
            <input id="name_category" type="text" class="form-control @error('name_category') is-invalid @enderror" name="name_category" value="{{ old('name_category',$data->name_category) }}">

            @error('name_category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>
            @if($data->id != "")
            <a class="btn btn-success" href="{{ route('categories.create') }}">{{__('Nova')}}</a>   
            @endif

            <a class="btn btn-secondary" href='{{route("categories")}}'>
            {{ __('Voltar') }}
            </a>
        </div>
    </div>

    </form>
</div>
 <!-- Main end -->
@endsection