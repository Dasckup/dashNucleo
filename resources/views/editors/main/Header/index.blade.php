<div class="search container">
    <form>
        <input class="form-control" type="text" placeholder="{{__('messages.header.search_placeholder')}}" aria-label="Search">
    </form>
    <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
</div>
<div class="app-header">
    <nav class="navbar navbar-light navbar-expand-lg container">
        <div class="container-fluid">
            <div class="navbar-nav" id="navbarNav">
                <div class="logo">
                    <a class="me-0" href="{{route("AppAuthor.home")}}">
                        <img width="30px" height="30px" src="{{asset("/template/assets/images/icons/logoicon.png")}}" alt="">    DASCKUP
                    </a>
                </div>

            </div>
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link active" href="">{{ __('messages.header.apps') }}</a>
                    </li>
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link" href="https://www.dasckup.com/fale-conosco">{{ __('messages.header.report_error') }}</a>
                    </li>
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link " href="https://dasckup.com">{{ __('messages.header.projects') }}</a>
                    </li>
                    <?php
                        function getLanguage() {
                            $languageUser = isset($_COOKIE['language_user'])? $_COOKIE['language_user'] : null;
                            if(!empty($languageUser)){
                                return $languageUser;
                            }else{
                                return 'en';
                            }
                        }
                    ?>
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link language-dropdown-toggle" href="#" id="languageDropDown" data-bs-toggle="dropdown"><img style=" width: 33px; height: 33px; "  src="{{asset('/template/assets/images/flags/'.getLanguage().'.png')}}" alt=""></a>
                        <ul class="dropdown-menu dropdown-menu-end language-dropdown" aria-labelledby="languageDropDown">
                            <?php
                                $languages = ['en', 'pt_BR', 'es', 'ru', 'fr', 'de', 'it'];
                                foreach ($languages as $language) {
                                    if($language !== getLanguage()){
                                        echo '<li><a class="dropdown-item" href="'.route('AppAuthor.lang.change', ['language' => $language]).'"><img width="30px" height="30px" src="'.asset('/template/assets/images/flags/'.$language.'.png').'" alt="">'.__('messages.language.'.$language.'_name').'</a></li>';
                                    }
                                }
                            ?>
                        </ul>
                    </li>

                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link nav-notifications-toggle" id="notificationsDropDown" href="#" data-bs-toggle="dropdown">0</a>
                        <div class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="notificationsDropDown">
                            <h6 class="dropdown-header">{{ __('messages.header.notifications') }}</h6>
                            <div class="notifications-dropdown-list">
                                {{--<a href="#">--}}
                                {{--    <div class="notifications-dropdown-item">--}}
                                {{--        <div class="notifications-dropdown-item-image">--}}
                                {{--            <span class="notifications-badge">--}}
                                {{--                <img src="{{asset("template/assets/images/avatars/avatar.png")}}" alt="">--}}
                                {{--            </span>--}}
                                {{--        </div>--}}
                                {{--        <div class="notifications-dropdown-item-text">--}}
                                {{--            <p>Praesent lacinia ante eget tristique mattis. Nam sollicitudin velit sit amet auctor porta</p>--}}
                                {{--            <small>yesterday</small>--}}
                                {{--        </div>--}}
                                {{--    </div>--}}
                                {{--</a>--}}

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
                                <a class="dropdown-item " href="{{route("AppAuthor.user.profile")}}" style=" display: flex; align-items: center; ">
                                    <i style="font-size: 22px" class="material-icons me-2">face</i> {{ __('messages.header.configuration') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route("AppAuthor.login.destroy")}}" style=" display: flex; align-items: center; ">
                                    <i style="font-size: 22px" class="material-icons me-2">logout</i>  {{ __('messages.header.logout') }}
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
            <li class="{{ request()->is('author') ? 'active-page' : '' }}">
                <a class="{{ request()->is('author') ? 'active-page' : '' }}" href="{{route("AppAuthor.home")}}">
                    {{ __('messages.header.my_materials') }}
                </a>
            </li>
            <li class="{{ request()->is('author/profile') ? 'active-page' : '' }}">
                <a class="{{ request()->is('author/profile') ? 'active-page' : '' }}" href="{{route("AppAuthor.user.profile")}}">
                    {{ __('messages.header.profile') }}
                </a>
            </li>
        </ul>
    </div>
</div>
