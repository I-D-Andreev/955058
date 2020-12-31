<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5db994464b.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/colours.css') }}" rel="stylesheet">

</head>
<body>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            
            <div class="container">
                
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('posts.index') }}">{{ __('Main') }}</a>
                            </li>
                            

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>


                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.show') }}">
                                        {{__('Profile')}}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <main class="py-4" style="height: 93%">
        <div class="row w-100">
            <div class="col-md-3">
                <div class="container ml-1">
                    <div>
                        <h2>Latest News:</h2>
                    </div>
                    @foreach ($newsApi->getNews()->articles as $article)
                        <div class="card mb-3">
                            <div class="card-header text-center">
                                <a href="{{$article->url}}" class="float-left">Visit</a>
                                <span>{{$article->source->name}}</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 d-none d-lg-block">
                                        <img class="img-fluid" src={{$article->urlToImage}} alt="Article Thumbnail">
                                    </div>
                                    <div class="col-md-8">
                                        {{$article->title}}
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-6">
                @yield('content')
            </div>

            <div id="notif" class="col-md-3">
                <ul class="list-group borderless sticky-top bg-transparent" v-for="notification in notifications"> 
                     {{-- Do not show initially as unrendered cards are displayed briefly on page load.  --}}
                    <div class="list-group-item border-0 bg-transparent" v-bind:id="notification.id" style="display:none">                
                        <div class="card w-75 m-auto">
                            <div class="card-header text-center bg-light-green">@{{notification.title}}</div>
                            <div class="card-body text-center">@{{notification.text}}</div>
                            <div class="card-footer w-100 bg-light-green">
                                <a href="#" @click="redirectToPost(notification.postId)">Visit</a>
                                <span class="float-right">By @{{notification.commenter}}</span>
                            </div>
                        </div>
                    </div>
                </ul>
            </div>
        
        </div>
    </main>

    <script src="{{ asset('js/app.js') }}"></script>   
    @stack('imports')

    <script>
        var userId = "{{Auth::id()}}";
        
        var vapp = new Vue({
            el: "#notif",
            data: {
                notifications: [],
            },
            methods: {
                redirectToPost: function(postId) {
                    let url = "{{route('posts.show', ['id' => ':id'])}}";
                    url = url.replace(':id', postId);
                    location.href = url;
                }
            },
        });        

        window.Echo.private(`App.User.${userId}`)
            .notification((notification) => {
                console.log(notification);
                vapp.notifications.push(notification);

                Vue.nextTick().then(function(){
                    let elementId = '#' + notification.id;
                    $(elementId).css("display", "block");
                    $(elementId).delay(5000).fadeOut();
                });  

            });
    </script>

    @yield('code')


</body>
</html>
