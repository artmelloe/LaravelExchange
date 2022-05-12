@extends('template.default')
@section('content')
    @include('template.head', ['title' => 'Log in'])
    <body class="body-login vh-100">
        <div class="container">
            <div class="text-center">
                <form class="form-login" method="post" action="{{ route('submit_login') }}">
                    @csrf
                    @if(Session::get('error'))
                        <div class="row">
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
                        <h1 class="h3 mb-3 font-weight-normal">Authentication</h1>
                        <input type="email" class="form-control" name="email" placeholder="Your email" required autofocus>
                        <input type="password" class="form-control" name="password" placeholder="Your password" required>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
@stop
