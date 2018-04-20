@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        {{ __('lang.changePassword.title') }}
        <small>{{ __('lang.changePassword.subtitle') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('lang.changePassword.breadcrumb.home') }}</a></li>
        <li><a href="#">{{ __('lang.changePassword.breadcrumb.security') }}</a></li>
        <li class="active">{{ __('lang.changePassword.breadcrumb.changePassword') }}</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('lang.changePassword.title') }}</h3>
              <p class="errorMessage text-center alert alert-danger hidden"></p>
            </div>
            <form >
              <input type="hidden" name="_token" value="{{ csrf_token() }}" >
              <div class="box-body">
                <div class="form-group">
                  <label for="oldPassword">{{ __('lang.changePassword.label.oldPassword') }} *</label>
                  <input type="password" name="oldPassword" class="form-control" id="oldPassword"
                  placeholder="{{ __('lang.changePassword.label.oldPassword') }}">
                  <p class="errorOldPassword text-center alert alert-danger hidden"></p>
                </div>
                <div class="form-group">
                  <label for="newPassword">{{ __('lang.changePassword.label.newPassword') }} *</label>
                  <input type="password" name="newPassword" class="form-control" id="newPassword"
                  placeholder="{{ __('lang.changePassword.label.newPassword') }}">
                  <p class="errorNewPassword text-center alert alert-danger hidden"></p>
                </div>
                <div class="form-group">
                  <label for="confirmPassword">{{ __('lang.changePassword.label.confirmPassword') }} *</label>
                  <input type="password" name="confirmPassword" class="form-control" id="confirmPassword"
                  placeholder="{{ __('lang.changePassword.label.confirmPassword') }}">
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
      $('#oldPassword').val('');
      $('#newPassword').val('');
      $('#confirmPassword').val('');

    }

    function hiddenError() {
      $('.errorOldPassword').addClass('hidden');
      $('.errorNewPassword').addClass('hidden');
      $('.errorConfirmPassword').addClass('hidden');
      $('.errorMessage').addClass('hidden');

    };

    $('.box-footer').on('click', '.add', function() {
        hiddenError();
        $.ajax({
            type: 'POST',
            url: '{{ url( '/ChangePassword/change' ) }}',
            data: {
                '_token': $('input[name=_token]').val(),
                'oldPassword': $('#oldPassword').val(),
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
                    if (data.errors.oldPassword) {
                        $('.errorOldPassword').removeClass('hidden');
                        $('.errorOldPassword').text(data.errors.oldPassword[0]);
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
