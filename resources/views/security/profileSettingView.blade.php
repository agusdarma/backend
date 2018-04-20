@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        {{ __('lang.profileSetting.title') }}
        <small>{{ __('lang.profileSetting.subtitle') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('lang.profileSetting.breadcrumb.home') }}</a></li>
        <li><a href="#">{{ __('lang.profileSetting.breadcrumb.security') }}</a></li>
        <li class="active">{{ __('lang.profileSetting.breadcrumb.profileSetting') }}</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('lang.profileSetting.title') }}</h3>
              <p class="errorMessage text-center alert alert-danger hidden"></p>
            </div>
            <form id="upload_form" enctype="multipart/form-data" method="POST" >
              <input type="hidden" name="_token" value="{{ csrf_token() }}" >
              <div class="box-body">
                <div class="form-group">
                  <label for="oldImage">{{ __('lang.profileSetting.label.oldImage') }} </label>
                  <br>
                  <img src="{{asset('images/avatar5.png')}}" width="100px" class="img-circle" alt="User Image">
                  <p class="errorOldImage text-center alert alert-danger hidden"></p>
                </div>
                <div class="form-group">
                  <label for="newImage">{{ __('lang.profileSetting.label.newImage') }} </label>
                  <input type="file" id="newImage" name="newImage">
                  <p class="errorNewImage text-center alert alert-danger hidden"></p>
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
      $('#oldImage').val('');

    }

    function hiddenError() {
      $('.errorOldImage').addClass('hidden');
      $('.errorMessage').addClass('hidden');

    };

    $('.box-footer').on('click', '.add', function() {
        // window.alert('agus');
        var form = document.forms.namedItem("upload_form"); // high importance!, here you need change "yourformname" with the name of your form
        var formdata = new FormData(form); // high importance!
        // console.log('agus darma kusuma');
          $.ajax({
              async: true,
              type: "POST",
              dataType: "json", // or html if you want...
              contentType: false, // high importance!
              url: '{{ url( '/ProfileSetting/upload' ) }}', // you need change it.
              data: formdata, // high importance!
              processData: false, // high importance!
              success: function(data) {
                console.log('2222');
                hiddenError();
                  if (data.rc!=0) {
                    console.log('444');
                      if (data.message) {
                          $('.errorEditMessage').removeClass('hidden');
                          $('.errorEditMessage').text(data.message);
                      }
                      if (data.errors.newImage) {
                          $('.errorNewImage').removeClass('hidden');
                          $('.errorNewImage').text(data.errors.newImage[0]);
                      }
                  } else {
                      // console.log('33333');
                      $('#editModal').modal('hide');
                      toastr.success(data.message, 'Success Alert', {timeOut: 2000});
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
