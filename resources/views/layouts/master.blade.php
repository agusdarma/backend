<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ __('lang.home.title') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  @yield('cssSelect2')
</head>
<?php use App\Http\Controllers\MainMenuController; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper" id="app">

  <header class="main-header">

    <a href="{{ url( '/MainMenu' ) }}" class="logo">
      <span class="logo-mini"><b>{{ __('lang.home.logo.mini') }}</b></span>
      <span class="logo-lg"><b>{{ __('lang.home.logo') }}</b></span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

    </nav>
  </header>

  <aside class="main-sidebar">

    <section class="sidebar">

      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('images/avatar5.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ MainMenuController::userLogged() }}</p>

          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
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

      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Main Navigation</li>
        <?php $results = MainMenuController::queryMainMenu(MainMenuController::userLevelId()); ?>
        @foreach ($results as $main)
        <li class="treeview">
            <?php $listSubMenu = MainMenuController::querySubMenu($main->menu_id,MainMenuController::userLevelId()); ?>
                @if (count($listSubMenu) > 0)
                    <a href="{{ url($main->menu_url) }}"><i class="{{$main->menu_icon}}"></i> <span>{{$main->menu_description}}</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @foreach ($listSubMenu as $sub)
                            <li><a href="{{ url($sub->menu_url) }}"><i class="{{$sub->menu_icon}}"></i> <span>{{$sub->menu_description}} </span></a></li>
                        @endforeach
                    </ul>
        </li>
                @else
                <a href="{{ url( $main->menu_url ) }}"><i class="{{$main->menu_icon}}"></i> <span>{{$main->menu_description}}</span>
                  <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                @endif
        @endforeach
        </li>
        <li><a href="{{ url( '/Logout' ) }}"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
      </ul>


    </section>

  </aside>


    @yield('content')



  <footer class="main-footer">

    <div class="pull-right hidden-xs">

    </div>

    <strong>{{ __('lang.footer.copyright') }} &copy; {{ __('lang.footer.copyright.year') }}
      <a href="{{ __('lang.footer.copyright.company.link') }}">{{ __('lang.footer.copyright.company') }}</a>.</strong>
      All rights reserved.
  </footer>
</div>

<script src="{{asset('js/app.js')}}"></script>
@yield('jsSelect2')
</body>
</html>
