<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title')</title>
        <meta name="description" content=@yield('metaDescription')>

        @section('header')
            <!-- Tell the browser to be responsive to screen width -->
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <!-- Bootstrap -->
            <link rel="stylesheet" href="/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
            <!-- Ionicons -->
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
            <!-- Date Picker -->
            <link rel="stylesheet" href="/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
            <!-- Daterange picker -->
            <link rel="stylesheet" href="/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
            <!-- jvectormap -->
            <link rel="stylesheet" href="/adminlte/bower_components/jvectormap/jquery-jvectormap.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="/adminlte/dist/css/AdminLTE.min.css">
            <!-- AdminLTE Skins. Choose a skin from the css/skins
                 folder instead of downloading all of them to reduce the load. -->
            <link rel="stylesheet" href="/adminlte/dist/css/skins/_all-skins.min.css">

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        @show
    </head>
    <body class="hold-transition skin-black sidebar-mini">
        <div class="wrapper">
            {{-- Main menu  --}}
                @yield('main_menu')
            {{-- END. Main menu --}}

            {{-- Main content section --}}
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper main-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">

                    </section>

                    <!-- Main content -->
                    <section class="content">
                        @yield('content')
                    </section>
                </div>
            {{-- END. Main content section --}}

            {{-- Footer --}}
                @yield('footer')
            {{-- END. Footer --}}

            {{-- Diff script for diff pages --}}
            {{-- Footer scripts --}}
                @section('footer_scripts')
                     <!-- REQUIRED JS SCRIPTS -->
                    <!-- jQuery 2.1.4 -->
                    <script src="/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
                    <!-- Bootstrap 3.3.5 -->
                    <script src="/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
                    <!-- MomentJs -->
                    <script src="/adminlte/bower_components/moment/min/moment.min.js"></script>
                    <script src="/adminlte/bower_components/moment/locale/ru.js"></script>
                    <!-- AdminLTE App -->
                    <script src="/adminlte/dist/js/adminlte.min.js"></script>
                    <!-- Optionally, you can add Slimscroll and FastClick plugins.
                         Both of these plugins are recommended to enhance the
                         user experience. Slimscroll is required when using the
                         fixed layout. -->
                @show
            {{-- END. Footer scripts --}}
        </div>
    </body>
</html>

