<html>
    <head>
        <title>Cost Control</title>
        {{ HTML::style('css/bootstrap.min.css') }}
        {{ HTML::style('css/costcontrol.css') }}
    </head>
    <body>
        <div id="site">
            @include('layouts.navigation')
            <div class="container">
                @if (Session::has('message'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                {{ Session::get('message') }}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-9 main-content">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                @yield('heading', 'Cost Control')
                            </div>
                            <div class="panel-body">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 sidebar-content">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                @yield('sub-navigation-heading', 'Cost Control Sub Navigation')
                            </div>
                            <div class="panel-body">
                                @yield('sidebar')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </body>
</html>