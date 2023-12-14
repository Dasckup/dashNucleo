<div class="app-sidebar">
    <div class="logo">
        <a href="/" style="background-image:url('{{asset("/template/assets/images/icons/logo_favicon.ico")}}')" class="logo-icon">
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

            <li class="{{ request()->is('intencao-de-submissao') ? 'active-page' : '' }}">
                <a class="" href="{{route("client.intention.index")}}">
                    <i class="material-icons-two-tone" style=" font-size: 29px; margin-right: 8px; ">psychology_alt</i> Intenção de Submissão
                </a>
            </li>

            <li class="{{ request()->is('submissoes/pendentes') ? 'active-page' : '' }}">
                <a class="{{ request()->is('submissoes/pendentes') ? 'active-page' : '' }} text-warning" href="{{route("client.index.pendente")}}">
                    <i class="material-icons-two-tone">hourglass_top</i> Pendentes
                </a>
            </li>

            <li class="{{ request()->is('submissoes/antendidos') ? 'active-page' : '' }}">
                <a class="{{ request()->is('submissoes/antendidos') ? 'active-page' : '' }} text-info" href="{{route("client.index.atendido")}}">
                    <i class="material-icons-two-tone">ring_volume</i> Atendidos
                </a>
            </li>

            <li class="{{ request()->is('submissoes/pagas') ? 'active-page' : '' }}">
                <a class="{{ request()->is('submissoes/pagas') ? 'active-page' : '' }} text-success" href="{{route("client.index.pagas")}}">
                    <i class="material-icons-two-tone text-success">payments</i> Pagas
                </a>
            </li>

            <li class="{{ request()->is('submissoes/cancelados') ? 'active-page' : '' }}">
                <a class="{{ request()->is('submissoes/cancelados') ? 'active-page' : '' }} text-danger" href="{{route("client.index.cancelados")}}">
                    <i class="material-icons-two-tone text-danger">cancel</i> Canceladas
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
