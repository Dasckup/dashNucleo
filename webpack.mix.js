const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles(
    [
        "resources/assets/plugins/bootstrap/css/bootstrap.min.css",
        "resources/assets/plugins/perfectscroll/perfect-scrollbar.css",
        "resources/assets/plugins/pace/pace.css",
        "resources/assets/plugins/highlight/styles/github-gist.css",
        "resources/assets/plugins/datatables/datatables.min.css",
    ],
    "public/template/assets/css/plugin.css"
)
    .styles(
        ["resources/assets/plugins/toastfy/css/toastify.css"],
        "public/template/assets/css/toastfy2.css"
    )

    .styles(
        [
            "resources/assets/css/main.min.css",
            "resources/assets/css/horizontal-menu/horizontal-menu.css",
            "resources/assets/css/custom.css",
        ],
        "public/template/assets/css/theme.css"
    )

    .scripts(
        [
            "resources/assets/plugins/jquery/jquery-3.5.1.min.js",
            "resources/assets/plugins/bootstrap/js/popper.min.js",
            "resources/assets/plugins/bootstrap/js/bootstrap.min.js",
            "resources/assets/plugins/perfectscroll/perfect-scrollbar.min.js",
            "resources/assets/plugins/highlight/highlight.pack.js",
        ],
        "public/template/assets/js/plugin.js"
    )
    .scripts(
        ["resources/assets/js/maps.js"],
        "public/template/assets/js/maps.js"
    )

    .scripts(
        ["resources/assets/plugins/jquery/jquery.validate.min.js"],
        "public/template/assets/js/jquery.validate.min.js"
    )

    .scripts(
        ["resources/assets/js/maps.js"],
        "public/template/assets/js/maps.js"
    )

    .scripts(
        [
            "resources/assets/plugins/apexcharts/apexcharts.min.js",
            "resources/assets/plugins/pace/pace.min.js",
            "resources/assets/js/pages/dashboard.js",
        ],
        "public/template/assets/js/apexcharts.js"
    )

    .scripts(
        [
            "resources/assets/plugins/datatables/datatables.min.js",
            "resources/assets/js/pages/datatables.js",
        ],
        "public/template/assets/js/datatables.js"
    )

    .scripts(
        [
            "resources/assets/plugins/blockUI/jquery.blockUI.min.js",
            "resources/assets/js/pages/blockui.js",
        ],
        "public/template/assets/js/blockui.js"
    )

    .scripts(
        [
            "resources/assets/plugins/toastfy/toastify-js.js",
            "resources/assets/plugins/toastfy/toastfy.js",
        ],
        "public/template/assets/js/toastfy.js"
    )

    .scripts(
        ["resources/assets/js/main.min.js", "resources/assets/js/custom.js"],
        "public/template/assets/js/theme.js"
    )

    .copyDirectory("resources/assets/images", "public/template/assets/images");
