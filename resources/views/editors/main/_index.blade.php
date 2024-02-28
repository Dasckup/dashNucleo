
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <link rel="icon" href="{{asset("/template/assets/images/icons/logo_favicon.ico")}}" />


    <!-- Title -->
    <title>Dasckup & Nucleo do Conhecimento</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{custom_asset("/template/assets/css/plugin.css")}}">
    <link rel="stylesheet" href="{{custom_asset("/template/assets/css/theme.css")}}">
    <link rel="stylesheet" href="{{custom_asset("/template/assets/css/toastfy2.css")}}">

    @yield('css')

</head>
<body>
    <div id="loader-wrapper" class="loader-wrapper">
        <div id="loading-text" class="loading-text">
            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
    </div>


    <div class="app horizontal-menu align-content-stretch d-flex flex-wrap">
        <div class="app-container">
            @include('authors.main.Header.index')
                @yield('content')
            @include('authors.main.Footer.index')
        </div>
    </div>


</body>
</html>

<script src="{{custom_asset("/template/assets/js/plugin.js")}}"></script>
<script src="{{custom_asset("/template/assets/js/theme.js")}}"></script>
<script src="{{custom_asset("/template/assets/js/toastfy.js")}}"></script>

<script>
    // Seu código JavaScript

    $(document).ready(() => {
        const loader = $("#loader-wrapper");
        setTimeout(() => {
            loader.fadeOut();
        }, 300);
    })
</script>
@yield('js')
