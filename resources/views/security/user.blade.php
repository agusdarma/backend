@extends('layouts.master')
<?php use App\Http\Controllers\UserDataController; ?>
<?php use App\Http\Controllers\MainMenuController; ?>
@section('content')
  <div class="content-wrapper">
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

    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('lang.user.title') }}</h3>
            </div>
            <form method="post" action="/UserData/Add">
              <input type="hidden" name="_token" value="{{ csrf_token() }}" >
              <div class="box-body">
                @if(session()->has('message.level'))
                    <div class="alert alert-{{ session('message.level') }}">
                    {!! session('message.content') !!}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                  <label for="firstName">{{ __('lang.user.label.firstName') }} *</label>
                  <input type="text" name="firstName" class="form-control" id="firstName" placeholder="{{ __('lang.user.label.firstName') }}">
                </div>
                <div class="form-group">
                  <label for="lastName">{{ __('lang.user.label.lastName') }}</label>
                  <input type="text" name="lastName" class="form-control" id="lastName" placeholder="{{ __('lang.user.label.lastName') }}">
                </div>
                <div class="form-group">
                  <label for="email">{{ __('lang.user.label.email') }} *</label>
                  <input type="email" name="email" class="form-control" id="email" placeholder="{{ __('lang.user.label.email') }}">
                </div>
                <div class="form-group">
                  <label for="phoneNo">{{ __('lang.user.label.phoneNo') }} *</label>
                  <input type="text" name="phoneNo" class="form-control" id="phoneNo" placeholder="{{ __('lang.user.label.phoneNo') }}">
                </div>
                <div class="form-group">
                  <?php $levels = UserDataController::listUserLevel(MainMenuController::userLevelId()); ?>
                  <label for="userLevel">{{ __('lang.user.label.userLevel') }} *</label>
                  <select id="levels" name="userLevel" class="form-control select2" style="width: 100%;">
                    @foreach($levels as $level)
                      <option value="{{ $level->id }}">{{ $level->level_name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="gender">{{ __('lang.user.label.gender') }} *</label>
                  <select id="gender" name="gender" class="form-control select2" style="width: 100%;">
                    <option value="male">Male</option>
                    <option value="female">Femaile</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="userName">{{ __('lang.user.label.userName') }}</label>
                  <input type="text" name="userName" class="form-control" id="userName" placeholder="{{ __('lang.user.label.userName') }}">
                </div>
                <div class="form-group">
                  <label for="password">{{ __('lang.user.label.password') }} *</label>
                  <input type="password" name="password" class="form-control" id="password" placeholder="{{ __('lang.user.label.password') }}">
                </div>
                <div class="form-group">
                  <label for="store">{{ __('lang.user.label.store') }}</label>
                  <input type="text" name="store" class="form-control" id="store" placeholder="{{ __('lang.user.label.store') }}">
                </div>
                <p class="help-block">* Required</p>
              </div>

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </section>
  </div>
@endsection
@section('jsSelect2')
<script src="{{asset('select2-4.0.5/dist/js/select2.full.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#levels').select2();
        $('#gender').select2();
     });
</script>
@endsection
@section('cssSelect2')
<link rel="stylesheet" href="{{asset('select2-4.0.5/dist/css/select2.min.css')}}">
@endsection
