@extends ('layouts.system')

@if ($data->id == "")
    @section('title', 'Criar Notícia')
@else
    @section('title', 'Atualizar Notícia')
@endif

@section('content')

<div class="container-fluid">
    @if ($data->id == "")

    <div class="d-flex align-items-center justify-content-between mt-3 mx-3">
        <h1 class="m-0">Criar Notícia</h1>
    </div>
    <hr>
    <form method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data">

    @else

    <div class="d-flex align-items-center justify-content-between mt-3 mx-3">
        <h1 class="m-0">Atualizar Noticia</h1>
    </div>
    <hr>
    <form method="POST" action="{{ route('news.update',$data) }}" enctype="multipart/form-data">
    @method('PUT')
    @endif

    @csrf

    <div class="row mb-3">
        <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('title') }}</label>

        <div class="col-md-6">
            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title',$data->title) }}">

            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="introduction" class="col-md-4 col-form-label text-md-end">{{ __('introduction') }}</label>

        <div class="col-md-6">
            <input id="introduction" type="text" class="form-control @error('introduction') is-invalid @enderror" name="introduction" value="{{ old('introduction',$data->introduction) }}">

            @error('introduction')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    @can('admin-access')
        @can('update', $data)
            <div class="row mb-3">
                <label for="category_id" class="col-md-4 col-form-label text-md-end">{{ __('category') }}</label>

                <div class="col-md-6">
                    <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                        <option disabled selected>--Selecione uma opcao--</option>
                        @foreach ($categoryList as $category)
                            <option value="{{$category->id}}">{{ $category->name_category}}</option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                    @if(isset($data))
                        @if(isset($categoryNews))
                            @foreach ($categoryNews as $cat)
                                @foreach ($categoryList as $category)
                                    @if($cat->category_id == $category->id)
                                        <a class="btn btn-sm btn-danger mt-2" href="{{route('category.desvincular', [$cat->id, 'dataNew'=>$data->id] )}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg> {{ $category->name_category}}</a>
                                    @endif
                                @endforeach
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        @endcan
    @endcan                     
    <div class="row mb-3">
        <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('image') }}</label>

    <div class="col-md-6">
        <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" 
        name="image">
        @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @if ($data->id)
            <img class="mt-3 rounded" src="{{asset($data->image)}}" width='200'/>
        @endif
        </div>
    </div>
        
    <div class="row mb-3">
        <label for="news_text" class="col-md-4 col-form-label text-md-end">{{ __('news_text') }}</label>

        <div class="col-md-6">
            <textarea class="form-control @error('news_text') is-invalid @enderror" name="news_text" id="news_text" cols="30" rows="10">{{ old('news_text',$data->news_text) }}</textarea>
            <script>
               tinymce.init({
                 selector: 'textarea#news_text',
                 menubar: false,
                 entity_encoding: 'raw',
                 plugins: 'link',
                 toolbar: 'undo redo styles bold italic alignleft aligncenter alignright alignjustify | bullist numlist outdent indent link',
               });
            </script>

            @error('news_text')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
@can('update', $data)
    <div class="row mb-3">

        <div class="col-md-6">
            <input id="slug" type="hidden" class="form-control" name="slug" disabled value="{{ old('slug',$data->slug) }}">
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>

            @if($data->id != "")
            <a class="btn btn-success" href="{{ route('news.create') }}">{{__('Nova')}}</a>   
            @endif

            <a class="btn btn-secondary" href='{{route("dashboard")}}'>
            {{ __('Voltar') }}
            </a>
        </div>
    </div>
@endcan
    </form>
</div>
 <!-- Main end -->
@endsection