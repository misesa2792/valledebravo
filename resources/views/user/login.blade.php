@extends('layouts.login')

@section('content')

    <div class="sbox ">

        <div class="sbox-title text-center">
            <div class="s-14"><strong>{{ CNF_APPNAME }}</strong></div>
        </div>

        <div class="sbox-content bg-white">

            <div class="text-center animated fadeInDown delayp1">
                <img src="{{ asset('mass/images/ses.png') }}" width="220" height="70" class="m-t-lg m-b-lg" />
            </div>

            @if (Session::has('message'))
                {!! Session::get('message') !!}
            @endif

            <ul class="parsley-error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <div class="tab-content">
                <div class="tab-pane active m-t" id="tab-sign-in">

                    <form method="post" action="{{ url('user/signin') }}" class="form-vertical">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group has-feedback animated fadeInLeft delayp1 m-t-md">
                            <label class="control-label s-14 c-text-alt">Correo electrónico</label>
                            <input type="text" name="email" placeholder="example@gmail.com" class="form-control p-l-35"
                                required="email" />
                            <i class="icon-users form-control-feedback com icon-left"></i>
                        </div>

                        <div class="form-group has-feedback  animated fadeInRight delayp1">
                            <label class="control-label s-14 c-text-alt">Contraseña</label>
                            <input type="password" name="password" placeholder="***************" class="form-control p-l-35"
                                required="true" id="txtpass" />
                            <i class="icon-lock form-control-feedback com icon-left"></i>
                        </div>

                        <div class="form-group has-feedback  animated fadeInRight delayp1 ">
                            <label>Remember Me?</label>
                            <input type="checkbox" name="remember" value="1" />
                        </div>

                        <div class="form-group  has-feedback text-center  animated fadeInLeft delayp1 m-t-lg m-b-md">
                            <button type="submit" class="btn btn-primary btn-md btn-block"><i class="fa fa-sign-in"></i> Iniciar Sesión</button>
                            <div class="clr"></div>
                        </div>

                    </form>
                </div>


            </div>

        </div>
    </div>
    <style media="screen">
        .p-l-35 {
            padding-left: 35px;
            height:35px;
        }

        .icon-left {
            margin-top: 0px;
            left: 0px;
            font-size: 16px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#or').click(function() {
                $('#fr').toggle();
            });
        });
    </script>
@stop
