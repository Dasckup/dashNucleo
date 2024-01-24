
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <link rel="icon" href="{{custom_asset("/template/assets/images/icons/logo_favicon.ico")}}" />
    <script>
        fetch("{{route('client.count.all')}}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                _token: "{{ csrf_token() }}",
                _method: "POST",
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.submissions) {
                for (const status in data.submissions) {
                    if (data.submissions.hasOwnProperty(status)) {
                        const el = document.getElementById("piu-count-" + status.replaceAll(" ", "_"));
                        if(ele) el.textContent = data.submissions[status];
                    }
                }
            }
        })
        .catch(error => console.error("Erro na requisição:", error));
    </script>

    <!-- Title -->
    <title>Dasckup & Nucleo do Conhecimento</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{custom_asset("/template/assets/css/plugin.css")}}">
    <link rel="stylesheet" href="{{custom_asset("/template/assets/css/theme.css")}}">
    <link rel="stylesheet" href="{{custom_asset("/template/assets/css/toastfy2.css")}}">
    @yield('css')

    <style>
        body{
            background: #e7ecf8!important;
        }
        .app-menu>ul>li>a>i:not(.has-sub-menu) {
            margin-right: 10px!important;
        }
        .app-menu>ul>li>a {
            font-size: 12px!important;
        }

        .badge-count-submitions{
            font-size: 9px!important;
            padding: 8px 4px!important;
            font-weight: 600!important;
            border: 1px solid !important;
            top: 12px;
            margin-right: 5px;
            background: transparent!important;
            line-height: 0px;
        }
        .badge-color-warning{
            color: var(--bs-warning);
            border-color: var(--bs-warning);
        }
        .badge-color-primary{
            color: var(--bs-primary);
            border-color: var(--bs-primary);
        }
        .badge-color-info{
            color: var(--bs-info);
            border-color: var(--bs-info);
        }
        .badge-color-danger{
            color: var(--bs-danger);
            border-color: var(--bs-danger);
        }
        .badge-color-pink{
            color: var(--bs-pink);
            border-color: var(--bs-pink);
        }
        .badge-color-success{
            color: var(--bs-success);
            border-color: var(--bs-success);
        }
        .badge-color-gray{
            color: var(--bs-gray);
            border-color: var(--bs-gray);
        }
        .badge-color-secondary{
            color: #40475c;
            border-color: #40475c;
        }
        .badge-color-red-light{
            color: #e3504b;
            border-color: #e3504b;
        }
        .app-menu>ul>li>a:hover span.badge-color-secondary{
            color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        i.material-symbols-outlined:hover{
            filter:none!important;
            color: var(--bs-primary)!important;
        }
        .app-menu>ul>li>a {
            margin: 3px 5px!important;
        }
        .accordion-menu li.sidebar-title {
            padding: 20px 15px 10px 22px!important;
        }
    </style>


</head>
<body>
    <div id="loader-wrapper" class="loader-wrapper">
        <div id="loading-text" class="loading-text">
            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
    </div>


    <div class="app align-content-stretch d-flex flex-wrap">
        @include('main.Header.index')

        <div class="app-container">
            @include('main.Header.navbar')
            @yield('content')
        </div>
    </div>

</body>
</html>

<script src="{{custom_asset("/template/assets/js/plugin.js")}}"></script>
<script src="{{custom_asset("/template/assets/js/theme.js")}}"></script>
<script src="{{custom_asset("/template/assets/js/toastfy.js")}}"></script>
<script src="{{custom_asset("/template/assets/js/apexcharts.js")}}"></script>

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
