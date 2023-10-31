<div class="search container">
    <form>
        <input class="form-control" type="text" placeholder="Digite aqui.." aria-label="Search">
    </form>
    <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
</div>
<div class="app-header">
    <nav class="navbar navbar-light navbar-expand-lg container">
        <div class="container-fluid">
            <div class="navbar-nav" id="navbarNav">
                <div class="logo">
                    <a href="{{route("home")}}">
                        <img width="30px" height="30px" src="{{asset("/template/assets/images/icons/logoicon.png")}}" alt="">    DASCKUP
                    </a>
                </div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">last_page</i></a>
                    </li>
                </ul>

            </div>
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link active" href="">Aplicativo</a>
                    </li>
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link" href="https://www.dasckup.com/fale-conosco">Reportar erro</a>
                    </li>
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link " href="https://dasckup.com">Projetos</a>
                    </li>



                    <li class="nav-item">
                        <a class="nav-link toggle-search" href="#"><i class="material-icons">search</i></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link ps-0" href="{{route("log")}}"><i class="material-icons">history</i></a>
                    </li>

                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link nav-notifications-toggle" id="notificationsDropDown" href="#" data-bs-toggle="dropdown">0</a>
                        <div class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="notificationsDropDown">
                            <h6 class="dropdown-header">Notificações</h6>
                            <div class="notifications-dropdown-list">
{{--                        <a href="#">--}}
{{--                            <div class="notifications-dropdown-item">--}}
{{--                                <div class="notifications-dropdown-item-image">--}}
{{--                                    <span class="notifications-badge">--}}
{{--                                        <img src="{{asset("template/assets/images/avatars/avatar.png")}}" alt="">--}}
{{--                                    </span>--}}
{{--                                </div>--}}
{{--                                <div class="notifications-dropdown-item-text">--}}
{{--                                    <p>Praesent lacinia ante eget tristique mattis. Nam sollicitudin velit sit amet auctor porta</p>--}}
{{--                                    <small>yesterday</small>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a>--}}

                                <div class="w-100 d-flex" style="min-height: 300px">

                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link language-dropdown-toggle" href="#" id="languageDropDown" data-bs-toggle="dropdown">
                            <img src="{{\Illuminate\Support\Facades\Auth::user()["cover"]}}" alt="">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end language-dropdown" aria-labelledby="languageDropDown">
                            <li>
                                <a class="dropdown-item " href="{{route("user.show")}}" style=" display: flex; align-items: center; ">
                                    <i style="font-size: 22px" class="material-icons me-2">face</i> Configuração
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route("login.destroy")}}" style=" display: flex; align-items: center; ">
                                    <i style="font-size: 22px" class="material-icons me-2">logout</i>  Sair
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<div class="app-menu">
    <div class="container">
        <ul class="menu-list">
            <li class="{{ request()->is('/') ? 'active-page' : '' }}">
                <a class="{{ request()->is('/') ? 'active-page' : '' }}" href="{{route("home")}}">
                    Dashboard
                </a>
            </li>

            <li class="{{ request()->is('submissoes') ? 'active-page' : '' }}">
                <a class="{{ request()->is('submissoes') ? 'active' : '' }}" href="{{route("client.index")}}">Submisssões</a>
            </li>

            <li class="{{ request()->is('intencao-de-submissao') ? 'active-page' : '' }}">
                <a class="{{ request()->is('intencao-de-submissao') ? 'active' : '' }}" href="{{route("client.intention.index")}}">Intenção de Submissão</a>
            </li>

            <li class="{{ request()->is('perfil') ? 'active-page' : '' }}">
                <a class="{{ request()->is('perfil') ? 'active' : '' }}" href="#">Perfil  <i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
                <ul class="sub-menu">
                    <li >
                        <a class="{{ request()->is('perfil') ? 'active' : '' }}" href="{{route("user.show")}}">
                            Configuração
                        </a>
                    </li>
                    <li >
                        <a href="{{route("login.destroy")}}">
                            Sair
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
