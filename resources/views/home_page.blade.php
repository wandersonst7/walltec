@extends('layouts.main')

@if(isset($search))
  @section('title', 'Exibindo resultados para: ' . $search) 
@else
  @section('title', 'Home')
@endif

@section('content')

{{-- Página de pesquisa --}}
@if(isset($search))
  <main>
    <section class="container-xl mb-5">
        <h5 id="welcome">Exibindo resultados para: {{ $search }}</h5>
        <div class="row w-100">
            <div class="col-md-3 cut-one">
                <hr class="cut cut-one">
            </div>

            @foreach($news as $n)
            <div class="col-md-3">
                <a href="{{ route('news.open', $n->slug )}}" class="text-decoration-none news-hover">
                <div class="box-default">
                    <img class="image-default img-fluid image-rounded" src="{{ asset($n->image) }}" alt="">
                    <div>
                        <h5 class="text-justify text-black">{{$n->title}}</h5>
                        <p class="date">{{$n->created_at->format('d/m/Y')}}</p>
                    </div>
                </div>
                </a>
                <hr class="cut">
            </div>
            @endforeach
            <div class="mt-2">
              {{ $news->appends(['search' => isset($search) ? $search : ''])->links() }}
            </div>
        </div>
    </section>
  </main>

{{-- Página Home --}}
@else
  <main>
      <section class="container-xl mb-5">
        <h5 id="welcome">Bem-vindo a WallTec.com</h5>
        @foreach($news as $destaque)
          <a href="{{ route('news.open', $destaque->slug )}}" class="text-decoration-none news-hover" id="recent-responsive">
            <div class="row" id="block-recent-responsive">
              <div class="col-md-6">
                <img id="image-recent" class="image-rounded" src="{{$destaque->image}}" alt="{{ $destaque->title }}">
              </div>
              <div class="col-md-6 text-recent mt-2">
                <h2 class="text-black">{{$destaque->title}}</h2>
                <p class="text-secondary">{{$destaque->introduction}}</p>
                <p class="date">{{$destaque->created_at->format('d/m/Y')}}</p>
              </div>
            </div>
          </a>
        @break
        @endforeach
      </section>

      <section class="container-xl mb-5">
        <div class="row w-100">
          <div class="col-md-3 cut-one">
            <hr class="cut">
          </div>
          @foreach($news as $n)
          <input class="d-none" value="{{$contador += 1}}">
          @if($contador == 1)
            @continue
          @else
          <div class="col-md-3">
            <a href="{{ route('news.open', $n->slug )}}" class="text-decoration-none news-hover">
              <div class="box-default">
                <img class="image-default img-fluid image-rounded" src="{{ $n->image }}" alt="{{ $n->title }}">
                <div>
                  <h5 class="text-black">{{ $n->title }}</h5>
                  <p class="date">{{$n->created_at->format('d/m/Y')}}</p>
                </div>
              </div>
            </a>
            <hr class="cut">
          </div>
          @endif
          @endforeach
          <div class="mt-2">
            {{ $news->links()}}
          </div>
        </div>
      </section>
  </main>

@endif

@endsection