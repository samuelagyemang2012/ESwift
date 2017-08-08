<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('css/blue.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{asset('css/morris.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset('css/jquery-jvectormap-1.2.2.css')}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('css/datepicker3.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('css/bootstrap3-wysihtml5.min.css')}}css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.css"/>

    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


    <![endif]-->

    @yield('header')
</head>


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="" class="logo">

            <span class="logo-mini"><b>A</b>LT</span>

        </a>

        <nav class="navbar navbar-static-top">

            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <li>
                        <a href="{{route('logout')}}">Logout</a>
                    </li>

                </ul>

            </div>

        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    {{--<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">--}}
                </div>
                <div class="pull-left info">
                    {{--<p>Administrator</p>--}}
                    {{--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>--}}
                </div>
            </div>

            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>

            <ul class="sidebar-menu">

                <li class="header"></li>
                <li><a href="{{route('home')}}"><i class="fa fa-television"></i> <span>Dashboard</span></a></li>

                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-money"></i> <span>Loans</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="active"><a href="{{route('admin_get_all_loans')}}"><i class="fa fa-circle-o"></i> All
                                Loans</a>
                        </li>
                        <li><a href="{{route('admin_get_pending_loans')}}"><i class="fa fa-circle-o"></i> Pending Loans</a>
                        </li>
                        <li><a href="{{route('admin_get_approved_loans')}}"><i class="fa fa-circle-o"></i> Approved
                                Loans</a></li>
                        <li><a href="{{route('admin_get_refused_loans')}}"><i class="fa fa-circle-o"></i> Refused Loans</a>
                        </li>
                        <li></li>
                    </ul>
                </li>

                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-credit-card"></i> <span>Make Payments</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('admin_pending_payments')}}"><i class="fa fa-circle-o"></i> Pending Transfers</a></li>
                        <li><a href="{{route('admin_completed_payments')}}"><i class="fa fa-circle-o"></i> Completed Transfers</a></li>
                        {{--<li><a href=""><i class="fa fa-circle-o"></i> Refused Loans</a></li>--}}
                        <li></li>
                    </ul>
                </li>


                <li class="treeview">
                    <a href=" {{route('clients')}}">
                        <i class="fa fa-users"></i>
                        <span>Manage Clients</span>
                    </a>
                </li>

                <li class="treeview">
                    <a href="{{route('packages')}}">
                        <i class="fa fa-cube"></i>
                        <span>Add Package</span>
                    </a>
                </li>


                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-user"></i> <span>Manage Personnel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        {{--<li class="active"><a href=""><i class="fa fa-circle-o"></i> All Loans</a></li>--}}
                        <li><a href="{{route('show_add_admin')}}"><i class="fa fa-circle-o"></i> Add New Admin</a></li>
                        <li><a href="{{route('show_add_payment')}}"><i class="fa fa-circle-o"></i>Add Payments Personnel</a></li>
                        <li><a href="{{route('show_add_transaction')}}"><i class="fa fa-circle-o"></i>Add Transactions Personnel</a></li>
                        <li><a href="{{route('show_change_password')}}"><i class="fa fa-circle-o"></i>
                                ChangePassword</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="{{route('get_debts')}}">
                        <i class="fa fa-bank"></i>
                        <span>Debts</span>
                    </a>
                </li>


                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-archive"></i> <span>System Logs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="active"><a href="{{route('show_client_logs')}}"><i class="fa fa-circle-o"></i>Client
                                Logs</a></li>
                        <li><a href="{{route('show_admin_logs')}}"><i class="fa fa-circle-o"></i> Admin Logs</a></li>
                    </ul>
                </li>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #fff">
        <!-- Content Header (Page header) -->
        {{--<section class="content-header">--}}
        {{--<h1>--}}
        {{--Dashboard--}}
        {{--<small>Control panel</small>--}}
        {{--</h1>--}}
        {{--<ol class="breadcrumb">--}}
        {{--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
        {{--<li class="active">Dashboard</li>--}}
        {{--</ol>--}}
        {{--</section>--}}

        {{--kmdsmdmsmdsmdmssmmdmsfsdfkdskfdskjfdsfjdlskfljsdljsdjkdjfahjhjhjhaskksdjlkfsjalkjfkslfdsflhshfsjhflshjsklhdjfhsfhsjsdkhfjsdkf--}}
                <!-- Main content -->
        <section class="content" style="background-color: #fff">
            <!-- Small boxes (Stat box) -->
            {{--<h1>jsdjfskfskfsdfsdfsdf</h1>--}}
            <div class="row">

                @yield('dashboard')

                        <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                @yield('content')




                {{--<div class="box-footer clearfix">--}}
                {{--                            @yield('content')--}}
                {{--</div>--}}
            </div>

        </section>
    </div>
    </section>
</div>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                            <p>Will be 23 on April 24th</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-user bg-yellow"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                            <p>New phone +1(800)555-1234</p>
                        </div>
                    </a>
                </li>
                <li>

                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-file-code-o bg-green"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                            <p>Execution time 5 seconds</p>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Custom Template Design
                            <span class="label label-danger pull-right">70%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Update Resume
                            <span class="label label-success pull-right">95%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Laravel Integration
                            <span class="label label-warning pull-right">50%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Back End Framework
                            <span class="label label-primary pull-right">68%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">General Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Report panel usage
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Some information about this general settings option
                    </p>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Allow mail redirect
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Other sets of options are available
                    </p>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Expose author name in posts
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Allow the user to show his name in blog posts
                    </p>
                </div>
                <!-- /.form-group -->

                <h3 class="control-sidebar-heading">Chat Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Show me as online
                        <input type="checkbox" class="pull-right" checked>
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Turn off notifications
                        <input type="checkbox" class="pull-right">
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Delete chat history
                        <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                    </label>
                </div>
                <!-- /.form-group -->
            </form>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>

<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

@yield('footer')

        <!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

<script src="{{asset('js/help.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{asset('js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('js/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{asset('js/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('js/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('js/jquery.knob.js')}}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{asset('js/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('js/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('js/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('js/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/app.min.js')}}"></script>

<script src="{{asset('js/validate.js')}}"></script>

@stack('scripts')

</body>
</html>
