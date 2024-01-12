@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

@endsection

<div class="app-sidebar">
    <div class="logo">
        <a href="/" style="background-image:url('{{custom_asset("/template/assets/images/icons/logo_favicon.ico")}}')" class="logo-icon">
            <span class="logo-text">Dasckup</span>
        </a>
        <div class="sidebar-user-switcher user-activity-online">
            <a href="#">
                <img src="{{ Auth::user()["cover"] }}">
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

            <li class="@if(routeIs('client.intention.index')) active-page @endif">
                <a style="color:var(--bs-)" href="{{ route('client.intention.index') }}">
                    <i class="material-icons">psychology_alt</i> Intenção de Submissão
                </a>
            </li>

            <li class="@if(routeIs('client.index.pendente')) active-page @endif">
                <a style="color:var(--bs-warning)" href="{{ route('client.index.pendente') }}">
                    <i style="filter:none" class="material-icons">ring_volume</i> Pendentes
                </a>
            </li>

            <li class="@if(routeIs('client.index.aceitos')) active-page  @endif">
                <a style="color:var(--bs-info)" href="{{ route('client.index.aceitos') }}">
                    <i style="filter:none" class="material-icons">inventory</i> Aceitos
                </a>
            </li>

            <li class="@if(routeIs('client.index.recusados')) active-page @endif">
                <a style="color:var(--bs-danger)" href="{{ route('client.index.recusados') }}">
                    <i style="filter:none" class="material-icons ">content_paste_off</i> Recusados
                </a>
            </li>

            <li class="@if(routeIs('client.index.pagamento_pendentes')) active-page @endif">
                <a style="color:var(--bs-pink)" href="{{ route('client.index.pagamento_pendentes') }}">
                    <i style="filter:none" class="material-icons ">currency_exchange</i> Pagamento Pendentes
                </a>
            </li>

            <li class="@if(routeIs('client.index.pagas')) active-page @endif">
                <a style="color:var(--bs-success)" href="{{ route('client.index.pagas') }}">
                    <i style="filter:none" class="material-icons ">paid</i> Pagos
                </a>
            </li>

            <li class="@if(routeIs('client.index.cancelados')) active-page @endif">
                <a style="color:var(--bs-gray)" href="{{ route('client.index.cancelados') }}">
                    <i style="filter:none" class="material-icons ">cancel</i> Cancelados
                </a>
            </li>

            <li class="sidebar-title">
                Sistema
            </li>

            <li class="{{ request()->is('perfil') ? 'active-page' : '' }}">
                <a class="{{ request()->is('perfil') ? 'active' : '' }}" href="#">
                    <i class="material-icons-two-tone text-danger">face_3</i> Perfil  <i class="material-icons has-sub-menu">keyboard_arrow_down</i>
                </a>

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
