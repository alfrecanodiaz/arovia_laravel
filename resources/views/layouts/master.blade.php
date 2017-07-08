<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Arovia - @yield('title')</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        {!! Html::style('vendor/jQueryUI/jquery-ui-1.10.3.custom.min.css') !!}
        {!! Html::style('vendor/bootstrap/dist/css/bootstrap.min.css') !!}
        {!! Html::style('themes/adminlte/plugins/datatables/dataTables.bootstrap.css') !!}
        {!! Html::style('vendor/font-awesome/css/font-awesome.css') !!}
        {!! Html::style('themes/adminlte/dist/css/AdminLTE.min.css') !!}
        {!! Html::style('themes/adminlte/dist/css/skins/_all-skins.min.css') !!}
        {!! Html::style('vendor/alertify/css/alertify.min.css') !!}
        {!! Html::style('vendor/alertify/css/alertify.rtl.min.css') !!}
        {!! Html::style('themes/adminlte/custom.css') !!}

        @section('styles')
        @show

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">

        <div class="wrapper">

            @include('partials.top-nav')

            @include('partials.left-sidebar')

                <div class="content-wrapper">

                    <section class="content-header">
                        @yield('content-header')
                        @include('flash::message')
                    </section>

                    <section class="content">
                        @yield('content-body')
                    </section>

                </div>

            @include('partials.footer')

            @include('partials.right-sidebar')

            <div class="control-sidebar-bg"></div>

        </div>

        {!! Html::script('vendor/jquery/jquery.min.js') !!}
        {!! Html::script('vendor/jquery-ui/jquery-ui.min.js') !!}
        {!! Html::script('themes/adminlte/plugins/datatables/jquery.dataTables.min.js') !!}
        {!! Html::script('themes/adminlte/plugins/datatables/dataTables.bootstrap.min.js') !!}
        {!! Html::script('vendor/bootstrap/dist/js/bootstrap.min.js') !!}
        {!! Html::script('themes/adminlte/plugins/slimScroll/jquery.slimscroll.min.js') !!}
        {!! Html::script('themes/adminlte/plugins/fastclick/fastclick.js') !!}
        {!! Html::script('vendor/alertify/alertify.min.js') !!}
        {!! Html::script('themes/adminlte/dist/js/app.min.js') !!}

        <script>
            $(document).ready(function ()
            {
                var current_url = window.location.href;
                $('li a[href="'+current_url+'"').parent('li').addClass('active').parent('ul').parent('li').addClass('active');
            })
        </script>

        @section('scripts')
        @show

        @include('partials.delete-modal')
    </body>
</html>