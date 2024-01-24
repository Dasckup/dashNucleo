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


            <li class="{{ request()->is('/intencao-de-submissao') ? 'active-page' : '' }}">
                <a class="{{ request()->is('/intencao-de-submissao') ? 'active-page' : '' }}" href="{{route("client.intention.index")}}">
                    <i class="material-icons-two-tone">psychology_alt</i>
                    <span id="piu-count-intention" class="badge-color-secondary badge-count-submitions badge badge-style-bordered">0</span>
                    Intenção de Submissão
                </a>
            </li>

            <li class="@if(routeIs('client.index.pendente')) active-page @endif">
                <a class="position-relative" style="color:var(--bs-warning)" href="{{ route('client.index.pendente') }}">
                    <i style="filter:none" class="material-icons">pending_actions</i>
                    <span id="piu-count-pendente" class="badge-color-warning badge-count-submitions badge badge-style-bordered">0</span>
                    Avaliação Pendentes
                </a>
            </li>

            <li class="@if(routeIs('client.index.pendencias')) active-page @endif">
                <a class="position-relative" style="color:#e3504b" href="{{ route('client.index.pendencias') }}">
                    <i style="filter:none" class="material-icons">error</i>
                    <span id="piu-count-pendencias" class="badge-color-red-light badge-count-submitions badge badge-style-bordered">0</span>
                    Com pendências
                </a>
            </li>

            <li class="@if(routeIs('client.index.atendidos')) active-page @endif">
                <a class="position-relative" style="color:var(--bs-primary)" href="{{ route('client.index.atendidos') }}">
                    <i style="filter:none" class="material-icons">phone_callback</i>
                    <span id="piu-count-atendido" class="badge-color-primary badge-count-submitions badge badge-style-bordered">0</span>
                    Em atendimento
                </a>
            </li>

            <li class="@if(routeIs('client.index.aceitos')) active-page  @endif">
                <a class="position-relative" style="color:var(--bs-info)" href="{{ route('client.index.aceitos') }}">
                    <i style="filter:none" class="material-symbols-outlined">inventory</i>
                    <span id="piu-count-aceito" class="badge-color-info badge-count-submitions badge badge-style-bordered">0</span>
                    Aceitos
                </a>
            </li>

            <li class="@if(routeIs('client.index.recusados')) active-page @endif">
                <a class="position-relative" style="color:var(--bs-danger)" href="{{ route('client.index.recusados') }}">
                    <i style="filter:none" class="material-icons ">content_paste_off</i>
                    <span id="piu-count-recusado" class="badge-color-danger badge-count-submitions badge badge-style-bordered">0</span>
                    Recusados
                </a>
            </li>

            <li class="@if(routeIs('client.index.pagamento_pendentes')) active-page @endif">
                <a class="position-relative" style="color:var(--bs-pink)" href="{{ route('client.index.pagamento_pendentes') }}">
                    <i style="filter:none" class="material-icons ">currency_exchange</i>
                    <span id="piu-count-pagamento_pendente" class="badge-color-pink badge-count-submitions badge badge-style-bordered">0</span>
                    Pagamento Pendentes
                </a>
            </li>


            <li class="@if(routeIs('client.index.pagas')) active-page @endif">
                <a class="position-relative" style="color:var(--bs-success)" href="{{ route('client.index.pagas') }}">
                    <i style="filter:none" class="material-icons ">paid</i>
                    <span id="piu-count-pago" class="badge-color-success badge-count-submitions badge badge-style-bordered">0</span>
                    Pagos
                </a>
            </li>

            <li class="@if(routeIs('client.index.cancelados')) active-page @endif">
                <a class="position-relative" style="color:var(--bs-gray)" href="{{ route('client.index.cancelados') }}">
                    <i style="filter:none" class="material-icons ">cancel</i>
                    <span id="piu-count-cancelado" class="badge-color-gray badge-count-submitions badge badge-style-bordered">0</span>
                    Cancelados
                </a>
            </li>






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
