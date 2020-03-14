<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }} - {{ $page_title }}</title>
        
        {!! Html::style('css/app.css') !!}
        {!! Html::style('css/mdb.min.css') !!}
        {!! Html::style('css/datatables.min.css') !!}
        {!! Html::style('fontawesome/css/all.css') !!}
        
        {!! Html::script('js/jquery-3.3.1.min.js') !!}
        {!! Html::script('js/popper.min.js') !!}
        {!! Html::script('js/app.js') !!}
        {!! Html::script('js/mdb.min.js') !!}
        {!! Html::script('js/datatables.min.js') !!}
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
        
        <script type="text/javascript">
            $(document).ready(function () {
                $('#myTable1').DataTable({
                    fixedHeader: true
                });
                $('#myTable2').DataTable({
                    fixedHeader: true
                });
                $('#myTable3').DataTable({
                    fixedHeader: true,
                    "order": [[ 0, "desc" ]],
                    "columnDefs": [
                        {
                            "targets": [ 0 ],
                            "visible": false,
                            "searchable": false
                        }
                    ]
                });
            });
            
            function confirmDisable() {
                if (confirm("Are you sure you want to disable this item?")) {
                    return true;
                } else {
                    return false;
                }
            }
            
            function confirmDelete() {
                if (confirm("Are you sure you want to completely delete this item?")) {
                    return true;
                } else {
                    return false;
                }
            }
        </script>

        <!-- Styles -->
        
    </head>
    
    <?php
    //$user = App\HrmEmployee::whereId(Session::get('fbnm_user')['id'])->first();
    ?>
    
    <body style="background-color: #f6f7fb;">
        <div class="container-fluid" style="height: 100vh;">
            <div class="row bg-dark" style="padding: 15px 0;">
                <div class="col-md-6">
                    <div class="text-white float-left" style="display: flex; align-items: center; justify-content: center;">
                        <!--{{ Html::image('images/logo-new.jpg', 'Halogen Logo', ['width' => 60]) }}&nbsp;&nbsp;-->
                        <h3><span class="font-weight-bold">Project</span>Plus</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="float-right text-white" style="display: flex; align-items: center; justify-content: center; height: 100%;">
                        {{ Session::get('pmp_user')['first_name']." ".Session::get('pmp_user')['surname'] }}
                        &nbsp;
                        <a href="{{ route('logout') }}" title="Log Out"><i class="fas fa-sign-out-alt fa-2x"></i></a>
                    </div>
                </div>
            </div>
            <div class="row bg-primary">
                <div class="col-12" style="height: 10px;">
                    
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="page-header" style="border-bottom: 1px solid #999; padding: 30px 0; margin-bottom: 20px; color: #999;">{{ $page_title }}</h1>
                </div>
            </div>
            @include('commons.message')
            <div class="row">
                <div class="col-md-2">
                    <div id="accordion" style="margin-bottom: 10px;">
                        <div class="card">
                            <div class="card-header bg-white" id="heading1" style="padding: 0;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                        <strong>Project Menu</strong>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#accordion">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                                        <a class="nav-link" href="{{ route('projects.index') }}">Projects</a>
                                        <a class="nav-link" href="{{ route('contractors.index') }}">Contractors</a>
                                        <a class="nav-link" href="{{ route('summary') }}">Summary</a>
                                    </nav>
                                </div>
                            </div> 
                        </div>
                        <div class="card">
                            <div class="card-header bg-white" id="heading2" style="padding: 0;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                                        <strong>Settings</strong>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        <a class="nav-link" href="#">Users</a>
                                    </nav>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 justify-content-end text-right">
                    <div style="border-top: 1px solid #999; margin-top: 20px; padding: 10px 0;">Powered by <a href="http://epinecng.com" target="_blank">Epinec</a></div>
                </div>
            </div>
        </div>
    </body>
</html>
