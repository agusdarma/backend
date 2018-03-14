<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ __('lang.home.title') }}</title>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<?php use App\Http\Controllers\MainMenuController; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper" id="app">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>{{ __('lang.home.logo.mini') }}</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{{ __('lang.home.logo') }}</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('images/avatar5.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ MainMenuController::userLogged() }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Main Navigation</li>
        <?php $results = MainMenuController::queryMainMenu(MainMenuController::userLevelId()); ?>
        @foreach ($results as $main)
        <li class="treeview">
            <?php $listSubMenu = MainMenuController::querySubMenu($main->menu_id); ?>
                @if (count($listSubMenu) > 0)
                    <a href="{{$main->menu_url}}"><i class="{{$main->menu_icon}}"></i> <span>{{$main->menu_description}}</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @foreach ($listSubMenu as $sub)
                            <li><a href="{{$sub->menu_url}}"><i class="{{$sub->menu_icon}}"></i> <span>{{$sub->menu_description}} </span></a></li>
                        @endforeach
                    </ul>
        </li>
                @else
                <a href="{{$main->menu_url}}"><i class="{{$main->menu_icon}}"></i> <span>{{$main->menu_description}}</span>
                  <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                @endif
        @endforeach
        </li>
        <li><a href="/Logout"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->

    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
    @yield('content')
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <!-- Anything you want -->
    </div>
    <!-- Default to the left -->
    <strong>{{ __('lang.footer.copyright') }} &copy; {{ __('lang.footer.copyright.year') }}
      <a href="{{ __('lang.footer.copyright.company.link') }}">{{ __('lang.footer.copyright.company') }}</a>.</strong>
      All rights reserved.
  </footer>
</div>

<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
