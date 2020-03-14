<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }} - Login</title>
        
        {!! Html::style('css/app.css') !!}
        {!! Html::style('css/mdb.min.css') !!}
        
        {!! Html::script('js/jquery-3.3.1.min.js') !!}
        {!! Html::script('js/popper.min.js') !!}
        {!! Html::script('js/app.js') !!}
        {!! Html::script('js/mdb.min.js') !!}
    </head>
    <body class="bg-dark">
        <div class="container-fluid" style="height: 100vh;">
            <div class="row" style="height: 100vh">
                <div class="col-12" style="margin-bottom: 30px; padding-top: 20px;">
                    <div class="text-white float-left" style="display: flex; align-items: center; justify-content: center;">
                        <!--{{ Html::image('images/logo-new.jpg', 'Halogen Logo', ['width' => 60]) }}&nbsp;&nbsp;-->
                        <h3><span class="font-weight-bold">Project</span>Plus</h3>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1" style="padding: 20px;">
                    <div class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="text-right">
                                    <h1 class="display-3 font-weight-bold text-danger">monitor projects</h1>
                                    <h3 class="text-white">Be aware of milestones<br />and deliverables.</h3>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="text-right">
                                    <h1 class="display-3 font-weight-bold text-danger">track spending</h1>
                                    <h3 class="text-white">Review expenses against<br />budget.</h3>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="text-right">
                                    <h1 class="display-3 font-weight-bold text-danger">gain insight</h1>
                                    <h3 class="text-white">Gauge project performance based on<br />time and money.</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="padding: 20px;">
                    <div class="bg-white" style="min-height: 450px; border-radius: 7px; padding: 50px;">
                        <h3 style="margin-bottom: 30px;"><span class="font-weight-bold">Log in to your profile</span></h3>
                        @include('commons.message')
                        {!! Form::open(['route' => ['authenticate'], 'class' => 'form-group', 'method' => 'post']) !!}
                        <div class="form-group" style="margin-bottom: 30px;">
                            {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Username', 'required' => true]) !!}
                        </div>
                        <div class="form-group" style="margin-bottom: 30px;">
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required' => true, 'id' => 'password']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Log In', ['class' => 'btn btn-primary btn-block']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="col-12 justify-content-end text-right text-white">Powered by <a href="http://epinecng.com" target="_blank">Epinec</a></div>
            </div>
        </div>
        
        <script type="text/javascript">
            String.prototype.hashCode = function() {
                var hash = "";
                if (this.length == 0)
                    return hash;
                for (i=0; i<this.length; i++) {
                    char = this.charCodeAt(i);
                    hash = ((hash << 5) - hash) + char;
                    hash = hash & hash;           // Convert to 32 bit integer
                }
                return hash;
            }

            function passwordHash() {
                var password = document.getElementById('password').value;
                //document.getElementById('password').value = password.hashCode();
                document.getElementById('password').value = password;
            }
        </script>
    </body>
</html>
