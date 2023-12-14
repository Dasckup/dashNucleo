<div class="app-header">
    <nav class="navbar navbar-light navbar-expand-lg">
        <div class="container-fluid">
            <div class="navbar-nav" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown hidden-on-mobile">
                        <a class="nav-link dropdown-toggle " href="#" id="exploreDropdownLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons-outlined">add</i>
                        </a>
                        <ul class="dropdown-menu dropdown-lg large-items-menu" aria-labelledby="exploreDropdownLink">
                            <li>
                                <h6 class="dropdown-header">Recursos para usuários</h6>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{route('events.index')}}">
                                    <h5 class="dropdown-item-title">
                                        Mensagens automáticas
                                        <span class="hidden-helper-text">ver mais <i class="material-icons ms-1">keyboard_arrow_right</i></span>
                                    </h5>
                                    <span class="dropdown-item-description">Otimize seu tempo e simplifique processos. Descubra o poder da automação com facilidade</span>
                                </a>
                            </li>
                        </ul>
                    </li>
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
                        <a class="nav-link language-dropdown-toggle" href="#" id="languageDropDown" data-bs-toggle="dropdown">
                            <img src="{{Auth::user()["cover"]}}" alt="">
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
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link nav-notifications-toggle" id="notificationsDropDown" href="#" data-bs-toggle="dropdown">0</a>
                        <div class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="notificationsDropDown">
                            <h6 class="dropdown-header">Notifications</h6>
                            <div class="notifications-dropdown-list">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
