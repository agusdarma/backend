@extends('layouts.master')
<?php use App\Http\Controllers\ResetPasswordController; ?>
<?php use App\Http\Controllers\MainMenuController; ?>
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        {{ __('lang.resetPassword.title') }}
        <small>{{ __('lang.resetPassword.subtitle') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('lang.resetPassword.breadcrumb.home') }}</a></li>
        <li><a href="#">{{ __('lang.resetPassword.breadcrumb.security') }}</a></li>
        <li class="active">{{ __('lang.resetPassword.breadcrumb.resetPassword') }}</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('lang.resetPassword.title') }}</h3>
              <p class="errorMessage text-center alert alert-danger hidden"></p>
            </div>
            <form >
              <input type="hidden" name="_token" value="{{ csrf_token() }}" >
              <div class="box-body">
                <div class="form-group">
                  <?php $listUser = ResetPasswordController::listUser(); ?>
                  <label for="user">{{ __('lang.resetPassword.label.user') }} *</label>
                  <select id="user" name="user" class="form-control select2" style="width: 100%;">
                    @foreach($listUser as $user)
                      <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                    @endforeach
                  </select>
                  <p class="errorUser text-center alert alert-danger hidden"></p>
                </div>
                <div class="form-group">
                  <label for="newPassword">{{ __('lang.resetPassword.label.newPassword') }} *</label>
                  <input type="password" name="newPassword" class="form-control" id="newPassword"
                  placeholder="{{ __('lang.resetPassword.label.newPassword') }}">
                  <p class="errorNewPassword text-center alert alert-danger hidden"></p>
                </div>
                <div class="form-group">
                  <label for="confirmPassword">{{ __('lang.resetPassword.label.confirmPassword') }} *</label>
                  <input type="password" name="confirmPassword" class="form-control" id="confirmPassword"
                  placeholder="{{ __('lang.resetPassword.label.confirmPassword') }}">
                  <p class="errorConfirmPassword text-center alert alert-danger hidden"></p>
                </div>
                <p class="help-block">{{ __('lang.form.required') }}</p>
              </div>

              <div class="box-footer">
                <button type="button" class="btn btn-success add">{{ __('lang.button.submit') }}</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </section>
  </div>
@endsection
@section('jsSelect2')
<script src="{{asset('toastr/js/toastr.min.js')}}"></script>
<script type="text/javascript">
    function clearInputAdd() {
      $('#user').val('');
      $('#newPassword').val('');
      $('#confirmPassword').val('');

    }

    function hiddenError() {
      $('.errorUser').addClass('hidden');
      $('.errorNewPassword').addClass('hidden');
      $('.errorConfirmPassword').addClass('hidden');
      $('.errorMessage').addClass('hidden');

    };

    $('.box-footer').on('click', '.add', function() {
        hiddenError();
        $.ajax({
            type: 'POST',
            url: '{{ url( '/ResetPassword/change' ) }}',
            data: {
                '_token': $('input[name=_token]').val(),
                'user': $('#user').val(),
                'newPassword': $('#newPassword').val(),
                'confirmPassword': $('#confirmPassword').val()

            },
            success: function(data) {
              hiddenError();
                if (data.rc!=0) {
                    if (data.errors.message) {
                        $('.errorMessage').removeClass('hidden');
                        $('.errorMessage').text(data.errors.message);
                    }
                    if (data.errors.user) {
                        $('.errorUser').removeClass('hidden');
                        $('.errorUser').text(data.errors.user);
                    }
                    if (data.errors.newPassword) {
                        $('.errorNewPassword').removeClass('hidden');
                        $('.errorNewPassword').text(data.errors.newPassword);
                    }
                    if (data.errors.confirmPassword) {
                        $('.errorConfirmPassword').removeClass('hidden');
                        $('.errorConfirmPassword').text(data.errors.confirmPassword);
                    }

                } else {
                    $('#modal-add').modal('hide');
                    toastr.success(data.message, 'Success Alert', {timeOut: 2000});
                    clearInputAdd();
                }
            },
            error: function(request, status, err) {
                if (status == "timeout") {
                    $('.errorMessage').removeClass('hidden');
                    $('.errorMessage').text('{{ __('lang.msg.ajax.timeout') }}');
                } else {
                    $('.errorMessage').removeClass('hidden');
                    $('.errorMessage').text("error: " + request + status + err);
                }
            },
            timeout: 10000
        });
    });
  </script>
@endsection
@section('cssSelect2')
<link rel="stylesheet" href="{{asset('toastr/css/toastr.min.css')}}">
@endsection
