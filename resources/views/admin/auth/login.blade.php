<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Jblog - Cpanel - Login</title>

    <!-- Styles -->
    <link href="/css/admin.css" rel="stylesheet">
    <style>
        #app {
            padding-top: 200px;
        }
    </style>
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app" class="container">
        <div class="column is-offset-4 is-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                <div class="field"{{ $errors->has('email') ? ' has-error' : '' }}>
                    <p class="control has-icon">
                        <input class="input" type="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                        <span class="icon is-small">
                            <i class="fa fa-envelope"></i>
                        </span>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </p>
                </div>
                <div class="field{{ $errors->has('password') ? ' has-error' : '' }}">
                    <p class="control has-icon">
                        <input class="input" type="password" placeholder="Password" required>
                        <span class="icon is-small">
                            <i class="fa fa-lock"></i>
                        </span>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </p>
                </div>
                <div class="field is-4">
                    <p class="control">
                        <label class="checkbox">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我
                        </label>
                    </p>
                </div>
                <div class="field">
                    <p class="control">
                        <button class="button is-success" style="width: 100%"> 登录 </button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <script src="/js/admin.js"></script>
</body>
</html>
