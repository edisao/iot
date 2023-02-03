<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>UNL</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-bold">UNL</h2>
                <p>Maestría en Ingeniería en Software.</p>
            </div>
            <div class="col-md-6">
                <div class="ibox-content">

                    <!-- Notificatio section -->
                    <!-- Valida si existe una variable de sesion
                 para mostrarla y removerla             -->
                    <?php
                    if (!empty($errorMessage)) {
                        echo "<div class=\"alert alert-danger alert-dismissable\">
                            <button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\"></button>
                            " . $errorMessage . "
                        </div>";
                    }
                    ?>
                    <!-- End Notificatio section -->

                    <form class="m-t" role="form" name="FormUserLogin" id="FormUserLogin" action="{{ route('auth.login') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <input id="Username" name="Username" type="text" class="form-control" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input id="Password" name="Password" type="password" class="form-control" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Ingresar</button>

                        
                    </form>

                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6">
                Universidad Nacional de Loja, Copyright, todos los derechos reservados.
            </div>
            <div class="col-md-6 text-right">
                <small>© 2022-2023</small>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/plugins/validate/additional-methods.min.js') }}"></script>

    <script>
        $(function() {

            $('#FormUserLogin').validate({
                rules: {
                    Username: {
                        required: true,
                    },
                    Password: {
                        required: true,
                    }
                },
                messages: {
                    Username: {
                        required: "{{ trans('validation.required', [ 'attribute' => 'Username']) }}",
                    },
                    Password: {
                        required: "{{ trans('validation.required', [ 'attribute' => 'Password']) }}",
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

        });
    </script>

</body>

</html>