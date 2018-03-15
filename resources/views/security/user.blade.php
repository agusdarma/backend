@extends('layouts.master')
<?php use App\Http\Controllers\UserDataController; ?>
<?php use App\Http\Controllers\MainMenuController; ?>
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ __('lang.user.title') }}
        <small>{{ __('lang.user.subtitle') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('lang.user.breadcrumb.home') }}</a></li>
        <li><a href="#">{{ __('lang.user.breadcrumb.security') }}</a></li>
        <li class="active">{{ __('lang.user.breadcrumb.user') }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('lang.user.title') }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
                <div class="form-group">
                  <label for="firstName">{{ __('lang.user.label.firstName') }} *</label>
                  <input type="text" class="form-control" id="firstName" placeholder="{{ __('lang.user.label.firstName') }}">
                </div>
                <div class="form-group">
                  <label for="lastName">{{ __('lang.user.label.lastName') }}</label>
                  <input type="text" class="form-control" id="lastName" placeholder="{{ __('lang.user.label.lastName') }}">
                </div>
                <div class="form-group">
                  <label for="email">{{ __('lang.user.label.email') }} *</label>
                  <input type="email" class="form-control" id="email" placeholder="{{ __('lang.user.label.email') }}">
                </div>
                <div class="form-group">
                  <label for="phoneNo">{{ __('lang.user.label.phoneNo') }} *</label>
                  <input type="text" class="form-control" id="phoneNo" placeholder="{{ __('lang.user.label.phoneNo') }}">
                </div>
                <div class="form-group">
                  <?php $levels = UserDataController::listUserLevel(MainMenuController::userLevelId()); ?>
                  <label for="userLevel">{{ __('lang.user.label.userLevel') }} *</label>
                  <select id="levels" class="form-control select2" style="width: 100%;">
                    @foreach($levels as $level)
                      <option value="{{ $level->id }}">{{ $level->level_name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="gender">{{ __('lang.user.label.gender') }} *</label>
                  </br>
                  <input type="radio" name="rdBtnMale" id="rdBtnMale" value="male">
                  <label for="gender">{{ __('lang.user.label.male') }}</label>
                  <input type="radio" name="rdBtnFemale" id="rdBtnFemale" value="female">
                  <label for="gender">{{ __('lang.user.label.female') }}</label>
                </div>
                <div class="form-group">
                  <label for="userName">{{ __('lang.user.label.userName') }} *</label>
                  <input type="text" class="form-control" id="userName" placeholder="{{ __('lang.user.label.userName') }}">
                </div>

                <p class="help-block">* Required</p>


                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" id="exampleInputFile">

                  <p class="help-block">Example block-level help text here.</p>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox"> Check me out
                  </label>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('jsSelect2')
<script src="{{asset('select2-4.0.5/dist/js/select2.full.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#levels').select2();
     });
</script>
@endsection
@section('cssSelect2')
<link rel="stylesheet" href="{{asset('select2-4.0.5/dist/css/select2.min.css')}}">
@endsection
