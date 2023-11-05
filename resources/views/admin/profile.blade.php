@extends('layouts.system')

@section('title', 'Meu perfil')

@section('content')

{{-- Main --}}
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mt-3 mx-3">
        <h1 class="m-0">Meu perfil</h1>
    </div>
    <hr>
    <div class="card w-75 m-auto">
        <div class="card-header">{{ __('Informações') }}</div>
    
        <div class="card-body">
            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
                <div class="col-md-6">
                    <input id="email" type="text" class="form-control" value="{{ Auth::user()->email }}" readonly>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Main end --}}

@endsection