<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>@yield('title')</title>
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico')}}" />
        <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
        <script src="{{ asset('js/jquery-3.6.3.min.js')}}"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark color-nav">
            <div class="container px-5 py-2">
                <a class="navbar-brand" href="{{ route('/') }}"><img id="logo-responsive" src="{{asset('img/logo.png')}}" alt=""></a>
                <div>
                  <div class="dropdown">
                    @guest
                    <button class="btn btn-secondary btn-login dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#fff" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                      </svg>
                    </button>
                    @endguest
                    @auth
                    <button class="btn btn-secondary btn-login dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="font-user">
                      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#fff" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                      </svg>
                      @php
                          $espaço = array_search(' ', str_split(Auth::user()->name));
                          if($espaço == 0){
                            $PRIMEIRO_NOME = Auth::user()->name;
                          }else{
                            $PRIMEIRO_NOME = substr(Auth::user()->name, 0, $espaço);
                          }
                          
                          echo $PRIMEIRO_NOME;
                      @endphp
                    </button>
                    @endauth
                    <ul class="dropdown-menu " style="z-index: 10001">
                      @guest
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('login')}}">Login</a></li>
                        <li><a class="dropdown-item" href="{{ route('register')}}">Cadastre-se</a></li>
                      @endguest
                      @auth
                      @can('admin-access')
                        <li><a class="dropdown-item" href="{{ route('dashboard')}}">Dashboard</a></li>
                      @elsecan('empresa-access')
                        <li><a class="dropdown-item" href="{{ route('dashboard')}}">Dashboard</a></li>
                      @endcan
                        <li class="dropdown-divider"></li>
                        <li>
                          <a class="dropdown-item" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                           {{ __('Sair') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                        </form>
                        </li>
                      @endauth
                    </ul>
                  </div>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-xl bg-light shadow-sm position-sticky top-0 w-100" style="z-index: 10000">
            <div class="container-fluid">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span>
                  Menu
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                  </svg>
                </span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 " id="topics">

                  <li class="nav-item">
                    <a class="nav-link text-secondary" href="{{ route('/') }}">Home</a>
                  </li>

                  @foreach($categoryListOfAllViews as $cat)
                    <li class="nav-item">
                      <a class="nav-link text-secondary" href="{{ route('category.open', $cat)}}">{{$cat->name_category}}</a>
                    </li>
                  @endforeach

                </ul>
                  <form class="d-flex justify-content-between align-items-center form-control p-0 m-0 w-auto form-search" id="form-search" method="GET" action="{{ route('/') }}">
                    @csrf
                    <input class="m-0 p-2" id="input-search" type="search" placeholder="Faça uma busca" aria-label="Faça uma busca" name="search" value="{{ old('search') }}">
                    <button class="m-0 p-2" type="submit">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 20 20">
                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                  </button>
                </form>
              </div>
            </div>
          </nav>
          @if(session('msg'))
            <p class="alert alert-primary text-center">{{ session('msg')}}</p>
          @endif
        @yield('content')
        
        <footer class="bg-dark pb-2">
          <div class="container-fluid d-flex justify-content-around flex-wrap-reverse w-100 p-4">
            <div class="explore mt-3">
              <h4 class="text-white">Explore no site</h4>
              <hr>
              <div class="d-flex between">
                
              @foreach($categoryListOfAllViews as $cat)
                @if($contCategory == 0)
                  <div class="d-flex flex-column me-5">
                @endif
                    <a href="{{ route('category.open', $cat)}}" class="nav-link text-white my-2 me-2">{{$cat->name_category}}</a>
                    <input type="hidden" value="{{ $contCategory += 1 }}">
                  @if($contCategory == 2)
                    <input type="hidden" value="{{ $contCategory = 0 }}">
                    </div>
                    @continue
                  @endif
              @endforeach

              @if(count($categoryListOfAllViews)%2 == 1)
                </div>
              @endif

              </div>
            </div>
            

            <div class="d-flex flex-column align-items-center my-3">
                <h4 class="text-white">Comunicação</h4>
                <ul class="list-inline text-center mb-0">
                  <li class="list-inline-item">
                      <a data-toggle="tooltip" data-placement="bottom" title="walltec_example"href="#!">
                          <span class="fa-stack fa-lg">
                              <i class="fas fa-circle fa-stack-2x"></i>
                              <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                          </span>
                      </a>
                  </li>
                  <li class="list-inline-item">
                      <a data-toggle="tooltip" data-placement="bottom" title="WallTec Example" href="#!">
                          <span class="fa-stack fa-lg">
                              <i class="fas fa-circle fa-stack-2x"></i>
                              <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                          </span>
                      </a>
                  </li>
                  <li class="list-inline-item">
                      <a data-toggle="tooltip" data-placement="bottom" title="walltec_example" href="#!">
                          <span class="fa-stack fa-lg">
                              <i class="fas fa-circle fa-stack-2x"></i>
                              <i class="fab fa-instagram fa-stack-1x fa-inverse"></i>
                          </span>
                      </a>
                  </li>
                  <li class="list-inline-item">
                    <a data-toggle="tooltip" data-placement="bottom" title="walltecexample@gmail.com" href="mailto: walltecexample@gmail.com">
                        <span class="fa-stack fa-lg">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fa-regular fa-envelope text-white fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                  </li>
                </ul>
            </div>
          </div>
      </footer>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/scripts.js')}}"></script>
    </body>
</html>
