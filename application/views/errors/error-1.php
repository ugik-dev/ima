<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../../../../">
    <meta charset="utf-8" />
    <title>PT INDOMETAL ASIA</title>
    <meta name="description" content="Login page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="<?= base_url() ?>assets/metronic/css/pages/login/classic/login-5.css" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="<?= base_url() ?>assets/metronic/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/metronic/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/metronic/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="<?= base_url() ?>assets/metronic/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/metronic/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/metronic/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/metronic/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon.png" />
</head>

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <!--begin::Main-->
    <div class="error error-5 d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="height: 800px;background-image: url(<?= base_url() ?>assets/metronic/media/error/bg5.jpg);">
        <!--begin::Content-->
        <div class="container d-flex flex-row-fluid flex-column justify-content-md-center p-12">
            <h1 class="error-title font-weight-boldest text-info mt-10 mt-md-0 mb-12">Oops!</h1>
            <p class="font-weight-boldest display-4">Something went wrong here.</p>
            <p class="font-size-h3"><?php if (!empty($message)) {
                                        echo $message;
                                    } else {
                                        echo "Data not found, please call customer service.";
                                    } ?>
            </p>
        </div>
        <!--end::Content-->
    </div>
    <script>
        var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
    </script>
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1400
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#3699FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#E4E6EF",
                        "dark": "#181C32"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1F0FF",
                        "secondary": "#EBEDF3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#3F4254",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#EBEDF3",
                    "gray-300": "#E4E6EF",
                    "gray-400": "#D1D3E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#7E8299",
                    "gray-700": "#5E6278",
                    "gray-800": "#3F4254",
                    "gray-900": "#181C32"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="<?= base_url() ?>assets/metronic/plugins/global/plugins.bundle.js"></script>
    <script src="<?= base_url() ?>assets/metronic/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="<?= base_url() ?>assets/metronic/js/scripts.bundle.js"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="<?= base_url() ?>assets/metronic/js/pages/custom/login/login-general.js"></script>
    <!--end::Page Scripts-->
</body>
<!--end::Body-->

</html>