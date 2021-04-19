<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Chat app</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <link href="//db.onlinewebfonts.com/c/1c45e28f8e86cc89876f003b953cc3e9?family=SF+Pro+Text" rel="stylesheet" type="text/css"/>
    <!-- <script src="{{ asset('js/main.js') }}"></script> -->
    <!-- <script  src="../../Jquery/prettify.js"></script> -->

    <script src="https://cdn.socket.io/4.0.1/socket.io.min.js" integrity="sha384-LzhRnpGmQP+lOvWruF/lgkcqD+WDVt9fU3H4BWmwP5u5LTmkUGafMcpZKNObVMLU" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <style>
        .add-post{
            color: #5c83ad;
            cursor:pointer;
            transition: 0.4s all;
        }
    </style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ __('page.app_name') }}
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
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('page.login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('page.register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item add-post" onclick="openModal(event)">
                                        <span style="margin-right: 10px;">
                                            &#x272A;
                                        </span>{{ __('page.create_post') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('page.logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                   
                                </div>
                            </li>
                            
                        @endguest
                        <li>
                            <div class="languages" style="display: flex;align-items:center">
                                <a class="dropdown-item add-post @if(Illuminate\Support\Facades\Session::get('locale') == 'kz') activeLang @else disactive @endif" href="{{ url('/lang/kz') }}">
                                    <img src="https://courstore.com/lubuhom/assets/images/flags/kk.svg" alt="">
                                </a>
                                <a class="dropdown-item add-post @if(Illuminate\Support\Facades\Session::get('locale') == 'ru') activeLang @else disactive @endif" href="{{ url('/lang/ru') }}">
                                    <img src="https://courstore.com/lubuhom/assets/images/flags/ru_RU.svg" alt="">
                                </a>
                                
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="modal-post" style="display: none" >
           
            <form action="{{ route('image.upload') }}" method="POST" class="modal-post-form" enctype="multipart/form-data">
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
                @csrf
                <h3>
                    {{ __('page.create_post') }}
                </h3>
                <label for="content">{{ __('page.content') }}:</label>
                <p>
                    <textarea name="content" id="textarea" cols="20" rows="5"></textarea>
                </p>
                <p>
                    <label for="image" class="upload"><i class="fa fa-upload"></i>{{ __('page.upload_image') }}</label>
                    <input type="file" name="image" accept="image/gif, image/jpeg, image/png" id="image" style="display:none" onchange="loadFile(event)">
                </p>
                <img id="output" width="100%"  height="150" style="object-fit: contain"/>
                <label>{{ __('page.choose_category') }}:</label>	
                <p class="categories">
                    @foreach(App\Models\PostCategory::all() as $category)
                        <span class="item"> <span class="item_name">{{ $category['name'] }}</span> <span class="icon">&#43;</span></span>
                    @endforeach
                </p>
                <input type="hidden" value="" id="items" name="categories">
                <p>
                    <input type="submit" class="submit-form">
                </p>
                
            </form>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script>
    
    let items = document.querySelectorAll(".modal-post-form .categories .item")
    let icons = document.querySelectorAll(".modal-post-form .categories .item .icon")
    let item_names = document.querySelectorAll(".modal-post-form .categories .item_name")

    let items2 = document.querySelectorAll(".modal-search-form .categories .item")
    let icons2 = document.querySelectorAll(".modal-search-form .categories .item .icon")
    let item_names2 = document.querySelectorAll(".modal-search-form .categories .item_name")
    
    function add_category(items, icons, item_names, targetId){
        let deleteIcon = "&#8722;";
        let addIcon = "&#43;"
        let hash = {}
        let items_add = {}
        let target_el = document.querySelector(targetId)
        let target_ar = target_el.value.split("")
        if(targetId == '#filter_post')
            for(let x = 0;x < target_ar.length;x++){
                items_add[target_ar[x]-1] = target_ar[x]
                hash[target_ar[x]-1] = true
            }
        
        for(let x = 0;x < items.length;x++){
            
            items[x].addEventListener('click',function(e){
                if(hash[x]) {
                    icons[x].innerHTML = addIcon
                    items[x].classList.remove("deleteStatus")
                    delete items_add[x]
                }
                else {
                    icons[x].innerHTML = deleteIcon
                    items[x].classList.add("deleteStatus")
                    items_add[x] = x+1
                }
                let parsed = Object.keys(items_add).map(key => items_add[key]).join('&')
                console.log(items_add)
                if(parsed != ''){
                    target_el.value = parsed
                }
                hash[x] = !hash[x]
            })
        }
    }
    add_category(items,icons,item_names,"#items")
    add_category(items2,icons2,item_names2,"#filter_post")
    
var loadFile = function(event) {
    document.getElementById("output").style.display = "block";
	var image = document.getElementById('output');
	image.src = URL.createObjectURL(event.target.files[0]);
};
function openModal(event){
    document.querySelector(".modal-post").style.display= "flex";
}
function closeModal(event){
    event.preventDefault();
    if(event.currentTarget == event.target) document.querySelector(".modal-post").style.display= "none";
}
</script>
@stack('scripts')
</html>
