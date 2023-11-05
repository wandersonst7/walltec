@extends('layouts.main')

@section('title', $category->name_category)

@section('content')

<main>
    <section class="container-xl mb-5">
        <h5 id="welcome">Categoria: {{ $category->name_category }}</h5>
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
            {{ $news->links() }}
        </div>
    </section>
</main>

@endsection