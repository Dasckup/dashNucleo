
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <link rel="icon" href="{{asset("/template/assets/images/icons/logo_favicon.ico")}}" />
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Dasckup & Núcleo do Conhecimento</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset("/template/assets/css/plugin.css")}}">
    <link rel="stylesheet" href="{{asset("/template/assets/css/theme.css")}}">
</head>

    <body>
    <div class="app horizontal-menu app-auth-sign-up align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">

        </div>
        <div class="app-auth-container position-relative">
            <div class="col-sm-12 position-relative">
                @error("error")
                <div class="alert alert-custom d-flex align-items-center position-absolute w-100 p-0" role="alert" style="bottom: 34px;box-shadow:initial">
                    <div class="custom-alert-icon icon-danger"><i class="material-icons-outlined">close</i></div>
                    <div class="alert-content">
                        <span class="alert-title">😓 Algo deu errado com seu login </span>
                        <span class="alert-text">{{$message}}</span>
                    </div>
                </div>
                @enderror
            </div>


            <div class="logo" >
                <a style="background-image: initial;font-size: 25px;padding: 0px" >Núcleo Conheimento</a>
            </div>
            <p class="auth-description">Este é dashboard feito para autores acompanharem seus materiais até a sua publicação </p>
            <form method="POST" action="{{route("AppAuthor.login.store")}}">
            @csrf
            <div class="auth-credentials m-b-xxl">
                <div class="position-relative">
                    <label for="signInEmail" class="form-label">E-mail <code>*</code></label>
                    <input value="{{ old('email') }}" name="email" type="text" class="form-control m-b-md @error("email") is-invalid @enderror" id="signInEmail" aria-describedby="signInEmail" placeholder="exemplo@dasckup.com">
                    @error("email")
                    <div class="invalid-tooltip">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="position-relative">
                    <label for="signInPassword" class="form-label">Senha <code>*</code></label>
                    <input value="{{ old('password') }}" name="password" type="password" class="form-control @error("password") is-invalid @enderror" id="signInPassword" aria-describedby="signInPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                    @error("password")
                    <div class="invalid-tooltip">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="position-relative mt-3">
                    <label class="auth-forgot-password ">
                        <input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}> Lembre-se de mim
                    </label>
                </div>
            </div>

            <div class="auth-submit">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="divider"></div>
            <div class="auth-alts d-flex justify-content-center">
                <a target="_blank" href="https://www.dasckup.com" class="auth-alts-google" style="background-image: url('http://localhost:8000/template/assets/images/icons/logo_favicon.png');background-size: 100%;width: 40px;height: 40px;"></a>
                <a target="_blank" href="https://www.nucleodoconhecimento.com.br/" class="auth-alts-google" style="background-image: url('http://localhost:8000/template/assets/images/icons/nucleologo.png');background-size: 100%;width: 40px;height: 40px;"></a>
            </div>

            </form>
            <div class="w-100 d-flex flex-column align-items-center" style="position: absolute;bottom: 0;left: 0">
                <span>Desenvolvido com 💖 por <a class="ms-2" href="https://dasckup.com">Dasckup</a></span>
                <p style="color: #666;font-size: 11px">Soluções a 1 clique de distância</p>
            </div>
        </div>
    </div>

    </body>
</html>
<script src="{{asset("/template/assets/js/plugin.js")}}"></script>
<script src="{{asset("/template/assets/js/theme.js")}}"></script>
