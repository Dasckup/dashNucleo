<div class="app-sidebar">
    <div class="logo">
        <a href="/" style="background-image:url('{{custom_asset("/template/assets/images/icons/logo_favicon.ico")}}')" class="logo-icon">
            <span class="logo-text">Dasckup</span>
        </a>
        <div class="sidebar-user-switcher user-activity-online">
            <a href="#">
                <img src="{{ photo_user(Auth::user()["cover"]) }}">
                <span class="activity-indicator"></span>
                <span class="user-info-text">{{ Auth::user()["name"] }}<br><span class="user-state-info">{{ Auth::user()["role"] }}</span></span>
            </a>
        </div>
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">
            <li class="{{ request()->is('/') ? 'active-page' : '' }}">
                <a class="{{ request()->is('/') ? 'active-page' : '' }}" href="{{route("home")}}">
                    <i class="material-icons-two-tone">dashboard</i>Dashboard
                </a>
            </li>
            <li class="sidebar-title">
                Vendas
            </li>


            <li>
                <a href="">
                    <i class="material-icons-two-tone">badge</i>
                    Autores <i class="material-icons has-sub-menu">keyboard_arrow_right</i>
                </a>
                <ul class="sub-menu" style="display: none;">
                    <li>
                        <a href="{{route('author.index')}}">Todos</a>
                    </li>
                    <li>
                        <a href="{{route('author.create')}}">Novo autor</a>
                    </li>
                    @canany(['admin'])
                        <li>
                            <a href="faq.html">Nova Submissão</a>
                        </li>
                    @endcanany
                </ul>
            </li>


            <li class="{{ request()->is('/intencao-de-submissao') ? 'active-page' : '' }}">
                <a class="{{ request()->is('/intencao-de-submissao') ? 'active-page' : '' }}" href="{{route("client.intention.index")}}">
                    <i class="material-icons-two-tone">psychology_alt</i>
                    <span id="piu-count-intention" class="badge-color-secondary badge-count-submitions badge badge-style-bordered">0</span>
                    Intenção de Submissão
                </a>
            </li>

            <?php
            /***
            <li class="@if(routeIs('client.index.pendente')) active-page @endif">
                <a class="position-relative" style="color:var(--bs-warning)" href="{{ route('client.index.pendente') }}">
                    <i style="filter:none" class="material-icons">pending_actions</i>
                    <span id="piu-count-pendente" class="badge-color-warning badge-count-submitions badge badge-style-bordered">0</span>
                    Avaliação Pendentes
                </a>
            </li>
            ***/
            ?>


            @foreach (\App\Models\Status::orderBy("order", "asc")->get() as $status)
                <li class="@if(routeIs('client.index', ['status' => $status->route])) active-page @endif">
                    <a class="position-relative" style="color:{{$status->color}}" href="{{ route('client.index', ['status' => $status->route]) }}">
                        <i style="filter:none" class="material-icons ">{{$status->icon}}</i>
                        <span
                        style="border-color:{{$status->color}}!important;
                               color:{{$status->color}}!important;"
                        id="piu-count-{{$status->route}}"
                        class="badge-count-submitions badge badge-style-bordered">0</span>
                        {{$status->name}}
                    </a>
                </li>
            @endforeach


          <?php
            /***

            <li class="sidebar-title">
                Sistema
            </li>

            @canany(['sales', 'admin'])
                <li class="{{ request()->is('/produtos/todos') ? 'active-page' : '' }}">
                    <a class="{{ request()->is('/produtos/todos') ? 'active-page' : '' }}" href="{{route("products.index")}}">
                        <i class="material-icons-two-tone">storefront</i>
                        <span id="piu-count-products" class="badge-color-secondary badge-count-submitions badge badge-style-bordered">0</span>
                        Produtos
                    </a>
                </li>
            @endcanany

            @canany(['director', 'admin'])
                <li class="{{ request()->is('/produtos/todos') ? 'active-page' : '' }}">
                    <a class="{{ request()->is('/produtos/todos') ? 'active-page' : '' }}" href="{{route("user.index")}}">
                        <i class="material-icons-two-tone">diversity_1</i>
                        <span id="piu-count-users" class="badge-color-secondary badge-count-submitions badge badge-style-bordered">0</span>
                        Colaboradores
                    </a>
                </li>
            @endcanany

            @canany('admin')
                <li class="{{ request()->is('/status/todos') ? 'active-page' : '' }}">
                    <a class="{{ request()->is('/status/todos') ? 'active-page' : '' }}" href="{{route("user.index")}}">
                        <i class="material-icons-two-tone">flag</i>
                        Status
                    </a>
                </li>
            @endcanany

            @canany(['director', 'admin'])
                <li class="{{ request()->is('/status/todos') ? 'active-page' : '' }}">
                    <a class="{{ request()->is('/status/todos') ? 'active-page' : '' }}" href="{{route("user.index")}}">
                        <i class=" material-icons-two-tone">lock</i>
                        Permissões
                    </a>
                </li>
            @endcanany

            @canany(['director', 'admin'])
                <li class="{{ request()->is('/status/todos') ? 'active-page' : '' }}">
                    <a class="{{ request()->is('/status/todos') ? 'active-page' : '' }}" href="{{route("user.index")}}">
                        <i class=" material-icons-two-tone">fmd_bad</i>
                        Reportar Bug
                    </a>
                </li>
            @endcanany
            ***/?>

        </ul>
    </div>
</div>


@php
    function routeIs(){
        $args = func_get_args();
        foreach ($args as $arg) {
            if (Route::is($arg)) {
                return true;
            }
        }
        return false;
    }
@endphp
