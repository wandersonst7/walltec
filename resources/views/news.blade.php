@extends('layouts.main')

@if($news)
    @section('title', $news->title)
@endif

@section('content')

@if($news)
    <main>
        <section class="container-xl mb-3">
            <div class="d-flex flex-wrap mt-5 box-father-news">
                <div class="d-flex box-father-box-news justify-content-center">
                    <div class="box-news">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="m-0 detail-blue"> 
                            @foreach($news->manycategories as $cat)
                            | {{ $cat->name_category }}
                            @endforeach
                            </h6>
                            <p class="m-0 detail-blue">{{ $news->created_at->format('d/m/Y') }}</p>
                        </div>
                        <p class="m-0"><small>Publicado por: <span class="detail-blue">{{ $news->user->name }}</span> </small></p>
                        <h2 class="mb-2 detail-blue">{{ $news->title }} </h2>
                        <p class="text-secondary mb-3 text-news">{{ $news->introduction }}</p>
                        <img class="img-fluid mb-3" src="{{ $news->image }} " alt="{{ $news->title}}">
                        
                        <textarea class="d-none" id="html_text">{{ $news->news_text }}</textarea>
                        <div id="print_text" class="mb-0"></div>  

                        <script>
                            let htmlText = document.getElementById('html_text').value
                            let printText = document.getElementById('print_text')
                            printText.innerHTML = htmlText;
                        </script>
                          
                    </div>
                </div>
                
                <div class="box-father-related">
                    <h2 class="mt-5 detail-blue">Relacionadas</h2>
                    <hr>
                    @foreach($related as $r)
                    @if($r->id == $news->id)
                        @continue
                    @else
                        <a href="{{ route('news.open', $r->slug )}}" class="text-decoration-none text-black news-hover">
                            <div class="box-related">
                                <div>
                                    <img class="img-fluid mb-2 image-rounded" src="{{ asset($r->image) }}" alt="{{ $r->title }}">
                                    <h5>{{ $r->title }}</h5>
                                </div>
                            </div>
                        </a>
                        <hr>
                    @endif
                    @endforeach
                </div>

                <div class="my-3 container LastCommentInsert">
                    <button id="btn-coment" class="btn btn-coments">Comentários</button>
                    <div id="box-coment" class="box-coments @if(count($comments) > 0) d-block @endif">
                        
                    <!-- Publicar novo comentário -->
                    @if(Auth::user())
                        <form class="my-3" action="{{ route('comment.store') }}" method="POST" id="form-comment">
                            @csrf
                            <input type="hidden" name="news_id" value="{{ $news->id }}">
                            <label for="text_comment">Escreva um comentário: </label>
                            <textarea class="form-control @error('text_comment') is-invalid @enderror" name="text_comment" id="text_comment" cols="10" rows="3"></textarea>
                            <span id="msgofensiva"></span>
                            @error('text_comment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="d-flex justify-content-end">
                                <input class="btn btn-primary mt-1" type="submit" value="Publicar">
                            </div>
                        </form>
                    @else
                        <div class="my-3">
                            <p class="m-0 text-secondary">Você precisa estar logado para comentar.</p>
                        </div>
                    @endif
                        
                        @if(count($comments) == 0)
                            <div class="my-3">
                                <p class="m-0 text-secondary">Ainda não há comentários nesta página.</p>
                            </div>
                        @else
                            @foreach($comments as $comment)
                                <div class="my-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        @if(isset($comment->user->name))
                                            <h5 class="detail-blue m-0">{{$comment->user->name}}</h5>
                                        @else
                                            <h5 class="detail-blue m-0"><em>Usuário excluído</em></h5>
                                        @endif
                                        <p class="m-0 text-secondary">{{ $comment->created_at->format('d/m/Y')}}</p>
                                    </div>

                                            <div class="d-flex py-3 align-items-center">
                                                {{-- Conteúdo do comentário --}}
                                                <div class="me-auto" style="max-width: 700px">
                                                    <p class="m-0 p-0 text-secondary">{{ $comment->text_comment }}</p>
                                                </div>
                                    @if(Auth::user())
                                        @if($comment->user_id == Auth::user()->id || Auth::user()->level == $admin_user)
                                                {{-- Botões de editar e excluir comentários --}}
                                                <div class="ms-auto p-0" style="width: 80px">
                                                    <form action="{{route('comment.destroy',$comment)}}" method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                    <button onclick="editComents({{ $comment->id }})" type="button" class="btn-transparent">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#355cdc" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                        </svg>
                                                    </button>
                                                    
                                                    <button type="submit" class="btn-transparent">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#355cdc" class="bi bi-trash" viewBox="0 0 16 16">
                                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>                                  
                                        @endif
                                    @endif
                                    <!-- Editar Comentário -->
                                    <form id="box-edit-coment" method="POST" action="{{ route('comment.update',$comment) }}" class="box-edit-coment">
                                        @method('PUT')
                                        @csrf
                                    
                                        <input id="idComent" type="hidden" value="{{ $comment->id }}">
                                        <label for="text_comment_edit">Editar comentário: </label>
                                        <textarea class="form-control @error('text_comment_edit.'.$comment->id) is-invalid @enderror"
                                        name="text_comment_edit[{{$comment->id}}]" id="text_comment_edit" cols="10"
                                        rows="3">{{ old("text_comment_edit[{$comment->id}]",$comment->text_comment) }}</textarea>
                                        <span id="msgofensivaEdit"></span>
                                        @error('text_comment_edit.'.$comment->id)
                                        <span class="invalid-feedback" role="alert" comment="{{$comment->id}}">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <div class="d-flex justify-content-end">
                                            <input class="btn btn-sm btn-primary my-1" type="submit" value="Salvar">
                                        </div>
                                    </form>
                                    
                                </div>
                                <hr class="m-0">
                            @endforeach
                            <div class="mt-2">{{ $comments->links() }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <script>
                // Abrir comentários
                var btn_coment = document.getElementById('btn-coment');
                var box_coment = document.getElementById('box-coment');

                function abrirComents(){
                    btn_coment.classList.toggle("btn-coments-active")
                    box_coment.classList.toggle("d-block")
                }

                btn_coment.addEventListener('click', abrirComents);

                // Abrir opção de editar
                var box_edit_coment = document.querySelectorAll('#box-edit-coment');
                var list_edit_id = document.querySelectorAll('#idComent');

                function editComents(id){
                    for(i = 0; i < list_edit_id.length; i++){
                        if(id == list_edit_id[i].value){
                            box_edit_coment[i].classList.toggle("box-edit-coment")
                            box_edit_coment[i].classList.toggle("box-edit-coment-active")
                        }
                    }
                }

                function InitComents(){
                    btn_coment.classList.add("btn-coments-active")
                    box_coment.classList.add("d-block")
                }
                
                $(function(){
                    InitComents()
                }
                );


                $(function(){
                    if ($('.invalid-feedback').length > 0){
                        var span = $('.invalid-feedback').eq(0)
                        editComents(span.attr('comment'))
                        $('html').scrollTop($('.invalid-feedback').offset().top);
                    }
                }
                );

                $(function(){
                    if ($('.alert-primary').length > 0){
                        $('html').scrollTop($('.LastCommentInsert').offset().top);
                    }
                }
                );

                // Validando comentários ofensivos
                var palavras = [
                    "pqp", 
                    "vsf", 
                    "foda", 
                    "puta", 
                    "merda",
                    "vai se fuder",
                    "puta que pariu",
                    "arrombado",
                    "viado",
                    "lixo",
                    "baba-ovo",
                    "babaca",
                    "bicha",
                    "buceta",
                    "boiola",
                    "canalha",
                    "caralho",
                    "chifruda",
                    "chifrudo",
                    "chereca",
                    "chochota",
                    "cocaina",
                    "corno",
                    "corna",
                    "cretino",
                    "cretina",
                    "cuzao",
                    "debiloide",
                    "defunto",
                    "demonio",
                    "escroto",
                    "estupida",
                    "fodido",
                    "idiota",
                    "imbecil",
                    "macaco",
                    "mocreia",
                    "otario",
                    "penis",
                    "punheta",
                    "retardado",
                    "sapatao",
                    "sapatão",
                    "trouxa",
                    "xereca",
                    "xota",
                    "xoxota",
                    "veado",
                    "vagabundo",
                    "vagabunda",
                    "siririca",
                    "rola",
                    "boquete",
                    "foda-se",
                    "fds",
                    "fodase",
                    "puta merda",
                    "teu cu",
                    "piranha",
                    "brocha"
                ];

                const formularioPublicar = document.getElementById("form-comment")
                formularioPublicar.onsubmit = evento => {
                    let campoComentario = document.getElementById("text_comment");
                    let comentario = document.getElementById("text_comment").value;
                    comentario = comentario.toLowerCase();

                    for(i = 0; i < palavras.length; i++){
                        let palavra = palavras[i];
                        if(comentario.indexOf(palavra) != -1){
                            evento.preventDefault();
                            campoComentario.classList.add('is-invalid');
                            document.getElementById("msgofensiva").innerHTML = "<strong style='color:red'> <small> Palavras ofensivas não serão permitidas. </small> </strong>";
                            return;
                        }
                    }

                }

                const formularioEditar = document.getElementById("box-edit-coment")
                formularioEditar.onsubmit = evento => {
                    let campoComentario = document.getElementById("text_comment_edit");
                    let comentario = document.getElementById("text_comment_edit").value;
                    comentario = comentario.toLowerCase();

                    for(i = 0; i < palavras.length; i++){
                        let palavra = palavras[i];
                        if(comentario.indexOf(palavra) != -1){
                            evento.preventDefault();
                            campoComentario.classList.add('is-invalid');
                            document.getElementById("msgofensivaEdit").innerHTML = "<strong style='color:red'> <small> Palavras ofensivas não serão permitidas. </small> </strong>";
                            return;
                        }
                    }

                }
            </script>
        </section>
    </main>
@endif


@endsection