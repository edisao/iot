<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">

<head>
    <!-- Google Analytics -->
    @include('layouts.partials.analytics-tracking')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Page title -->
    <title>@yield('page_title')</title>

    <!-- Toast Notification -->
    <link rel="stylesheet" href="{{asset('/css/plugins/toastr/toastr.min.css')}}">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/font-awesome/css/font-awesome.css') }}">

    <!-- Animate -->
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Css DataTables -->
    @yield('css_datatable')
    
    <!-- Css Daterangepicker -->
    @yield('css_daterangepicker')
    
    <!-- Css summernote -->
    @yield('css_summernote')

    <!-- Css select2 -->
    @yield('css_select2')
    
    <!-- Css Tagsinputs -->
    @yield('css_tagsinput')
    
    <!-- Css orderitems -->
    @yield('css_order_items')

    @yield('css_lightbox2')

    @yield('css_fullcalendar')
    
    @yield('css_datetimepicker')

    <!-- Custom css -->
    <style>
        .tooltip {
            top: 0;
        }

        .bootstrap-tagsinput {
            width: 100%;
        }

        @yield('css');
    </style>
</head>

<body class="">
    <div id="wrapper">

        <!-- Navbar: menú de navegación de la Izquierda -->
        @include('layouts.partials.navbar')
        
        <!-- /.navbar -->

        <!-- Contenido de la pagina -->
        <div id="page-wrapper" class="gray-bg">
            <!-- Barra superior de la pagina -->
            @include('layouts.partials.topbar')
            <!-- End Barra superior de la pagina -->

            <!-- Content page -->
            @yield('page_content')

            <!-- Footer -->
            @include('layouts.partials.footer')
            <!-- /.footer -->
        </div>
        <!-- End Contenido de la pagina -->

        
        
        
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- Daterangepicker -->
    @yield('js_daterangepicker')
    
    <!-- Select2 -->
    @yield('js_select2')
    
    <!-- DataTables -->
    @yield('js_datatable')
    
    <!-- Summernote -->
    @yield('js_summernote')
        
    <!-- jquery-validation -->
    @yield('js_validation')

    <!-- BS custom file -->
    @yield('js_custom_upload_file')
    
    <!-- Tagsinputs -->
    @yield('js_tagsinput')
    
    <!-- Js OrderItems -->
    @yield('js_order_items')

    @yield('js_lightbox2')

    
    @yield('js_datetimepicker')
    
    <!-- Script -->
    @yield('script')
    
    <!-- Toast Notification -->
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        
        @yield('script_internal')

        // Modal de confirmacion para eliminar un registro
        $('#modal-confirm-delete').on('show.bs.modal',
            function(e) {
                $(this).find('.btn-confirm-delete-ok').attr('href', $(e.relatedTarget).data('href'));
                document.getElementById("modal-data-delete").textContent=$(e.relatedTarget).data('name');
            }
        );
        // Modal de confirmacion para eliminar un registro

        // Activa el tooltip
        $("body").tooltip({
            selector: '[data-toggle=tooltip]'
        });
        // End activa el tooltip

        // Javascript para activar el link a un tab
        window.onload = function() {
            var url = document.location.toString();
            if (url.match('#')) {
                $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
            }
            //Change hash for page-reload
            $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').on('shown', function(e) {
                window.location.hash = e.target.hash;
            });
            // End JavaScript para activar la navegacion entre tabs mediente un link
        }
    </script>
    {!! Toastr::message() !!}
</body>

</html>