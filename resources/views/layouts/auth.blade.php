<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $setting->nama_perusahaan }} | Login</title>
    <link rel="icon" href="{{ url($setting->path_logo) }}" type="image/png">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/AdminLTE/dist/css/adminlte.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    @stack('css')
</head>
<body>
    
    @yield('login')

    <!-- jQuery 3 -->
    <script src="{{ asset('/AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Validator -->
    <script src="{{ asset('js/validator.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const loginButton = document.getElementById('loginButton');

            function checkFormValidity() {
                if (emailInput.value && passwordInput.value) {
                    loginButton.removeAttribute('disabled');
                } else {
                    loginButton.setAttribute('disabled', 'disabled');
                }
            }

            emailInput.addEventListener('input', checkFormValidity);
            passwordInput.addEventListener('input', checkFormValidity);

            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        }, false);
    </script>
</body>
</html>
