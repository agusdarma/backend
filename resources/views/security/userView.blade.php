@extends('layouts.master')
<?php use App\Http\Controllers\UserDataController; ?>
<?php use App\Http\Controllers\MainMenuController; ?>
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        {{ __('lang.user.view.title') }}
        <small>{{ __('lang.user.view.subtitle') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('lang.user.breadcrumb.home') }}</a></li>
        <li><a href="#">{{ __('lang.user.breadcrumb.security') }}</a></li>
        <li class="active">{{ __('lang.user.breadcrumb.user.view') }}</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('lang.user.view.title') }}</h3>
              <button type="button" data-toggle="modal" onclick="hiddenError()" data-target="#modal-add"
              class="btn btn-primary">{{ __('lang.button.add.new.user') }}</button>
            </div>
                <table class="table table-bordered" id="users-table">
                    <thead>
                        <tr>
                            <th>{{ __('lang.user.view.table.id') }}</th>
                            <th>{{ __('lang.user.view.table.firstName') }}</th>
                            <th>{{ __('lang.user.view.table.email') }}</th>
                            <th>{{ __('lang.user.view.table.phoneNo') }}</th>
                            <th>{{ __('lang.user.view.table.levelName') }}</th>
                            <th>{{ __('lang.user.view.table.action') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>{{ __('lang.user.view.table.id') }}</th>
                          <th>{{ __('lang.user.view.table.firstName') }}</th>
                          <th>{{ __('lang.user.view.table.email') }}</th>
                          <th>{{ __('lang.user.view.table.phoneNo') }}</th>
                          <th>{{ __('lang.user.view.table.levelName') }}</th>
                        </tr>
                    </tfoot>
                </table>
          </div>

        </div>
      </div>
    </section>
  </div>
  <div class="modal fade" id="modal-add">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ __('lang.button.add.new.user') }}</h4>
              </div>
              <div class="modal-body">
                <div class="box box-primary">
                  <form>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                    <div class="box-body">
                      <div class="form-group">
                        <p class="errorMessage text-center alert alert-danger hidden"></p>
                        <label for="firstName">{{ __('lang.user.label.firstName') }} *</label>
                        <input type="text" name="firstName" class="form-control" id="firstName" placeholder="{{ __('lang.user.label.firstName') }}">
                        <p class="errorFirstName text-center alert alert-danger hidden"></p>
                      </div>
                      <div class="form-group">
                        <label for="lastName">{{ __('lang.user.label.lastName') }}</label>
                        <input type="text" name="lastName" class="form-control" id="lastName" placeholder="{{ __('lang.user.label.lastName') }}">
                        <p class="errorLastName text-center alert alert-danger hidden"></p>
                      </div>
                      <div class="form-group">
                        <label for="email">{{ __('lang.user.label.email') }} *</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="{{ __('lang.user.label.email') }}">
                        <p class="errorEmail text-center alert alert-danger hidden"></p>
                      </div>
                      <div class="form-group">
                        <label for="phoneNo">{{ __('lang.user.label.phoneNo') }} *</label>
                        <input type="text" name="phoneNo" class="form-control" id="phoneNo" placeholder="{{ __('lang.user.label.phoneNo') }}">
                        <p class="errorPhoneNo text-center alert alert-danger hidden"></p>
                      </div>
                      <div class="form-group">
                        <?php $levels = UserDataController::listUserLevel(MainMenuController::userLevelId()); ?>
                        <label for="userLevel">{{ __('lang.user.label.userLevel') }} *</label>
                        <select id="userLevel" name="userLevel" class="form-control select2" style="width: 100%;">
                          @foreach($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->level_name }}</option>
                          @endforeach
                        </select>
                        <p class="errorUserLevel text-center alert alert-danger hidden"></p>
                      </div>
                      <div class="form-group">
                        <label for="gender">{{ __('lang.user.label.gender') }} *</label>
                        <select id="gender" name="gender" class="form-control select2" style="width: 100%;">
                          <option value="male">Male</option>
                          <option value="female">Femaile</option>
                        </select>
                        <p class="errorGender text-center alert alert-danger hidden"></p>
                      </div>
                      <div class="form-group">
                        <label for="userName">{{ __('lang.user.label.userName') }}</label>
                        <input type="text" name="userName" class="form-control" id="userName" placeholder="{{ __('lang.user.label.userName') }}">
                        <p class="errorUserName text-center alert alert-danger hidden"></p>
                      </div>
                      <div class="form-group">
                        <label for="password">{{ __('lang.user.label.password') }} *</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="{{ __('lang.user.label.password') }}">
                        <p class="errorPassword text-center alert alert-danger hidden"></p>
                      </div>
                      <div class="form-group">
                        <label for="store">{{ __('lang.user.label.store') }}</label>
                        <input type="text" name="store" class="form-control" id="store" placeholder="{{ __('lang.user.label.store') }}">
                        <p class="errorStore text-center alert alert-danger hidden"></p>
                      </div>
                      <p class="help-block">{{ __('lang.form.required') }}</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-success add">{{ __('lang.button.submit') }}</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection
@section('jsSelect2')
    <script src="{{asset('dataTables-1.10.7/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('toastr/js/toastr.min.js')}}"></script>
    <script>
    $(function() {

        $('#users-table').DataTable({
            searching: true,
            processing: true,
            serverSide: true,
            ajax: '{!! route('getListUserData') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'first_name', name: 'first_name' },
                { data: 'email', name: 'email' },
                { data: 'phone_no', name: 'phone_no' },
                { data: 'level_name', name: 'level_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement('input');
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });
          }
       });
    });

    </script>
    <script type="text/javascript">
        function clearInput() {
          $('#modal-add').on('hidden.bs.modal', function () {
                  $('.modal-body').find('textarea,input').val('');
          });
        }
        function hiddenError() {
          $('.errorFirstName').addClass('hidden');
          $('.errorEmail').addClass('hidden');
          $('.errorPhoneNo').addClass('hidden');
          $('.errorUserLevel').addClass('hidden');
          $('.errorGender').addClass('hidden');
          $('.errorPassword').addClass('hidden');
          $('.errorMessage').addClass('hidden');
          clearInput();
        };
        function RefreshTable(tableId, urlData){
          $.getJSON(urlData, null, function( json )
          {
            table = $(tableId).dataTable();
            oSettings = table.fnSettings();
            table.fnClearTable(this);
            for (var i=0; i<json.aaData.length; i++)
            {
              table.oApi._fnAddData(oSettings, json.aaData[i]);
            }
            oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
            table.fnDraw();
          });
        }
        $('.modal-footer').on('click', '.add', function() {
            $.ajax({
                type: 'POST',
                url: '{{ url( '/UserData/AddAjax' ) }}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'firstName': $('#firstName').val(),
                    'lastName': $('#lastName').val(),
                    'email': $('#email').val(),
                    'phoneNo': $('#phoneNo').val(),
                    'userLevel': $('#userLevel').val(),
                    'gender': $('#gender').val(),
                    'userName': $('#userName').val(),
                    'password': $('#password').val(),
                    'store': $('#store').val()



                },
                success: function(data) {
                  hiddenError();
                    if (data.rc!=0) {
                        if (data.message) {
                            $('.errorMessage').removeClass('hidden');
                            $('.errorMessage').text(data.message);
                        }
                        if (data.errors.firstName) {
                            $('.errorFirstName').removeClass('hidden');
                            $('.errorFirstName').text(data.errors.firstName[0]);
                        }
                        if (data.errors.email) {
                            $('.errorEmail').removeClass('hidden');
                            $('.errorEmail').text(data.errors.email);
                        }
                        if (data.errors.phoneNo) {
                            $('.errorPhoneNo').removeClass('hidden');
                            $('.errorPhoneNo').text(data.errors.phoneNo);
                        }
                        if (data.errors.userLevel) {
                            $('.errorUserLevel').removeClass('hidden');
                            $('.errorUserLevel').text(data.errors.userLevel);
                        }
                        if (data.errors.gender) {
                            $('.errorGender').removeClass('hidden');
                            $('.errorGender').text(data.errors.gender);
                        }
                        if (data.errors.password) {
                            $('.errorPassword').removeClass('hidden');
                            $('.errorPassword').text(data.errors.password);
                        }
                    } else {
                        $('#modal-add').modal('hide');
                        toastr.success(data.message, 'Success Alert', {timeOut: 2000});
                        RefreshTable('#users-table','{!! route('getListUserData') !!}');
                    }
                },
            });
        });
      </script>

@endsection
@section('cssSelect2')
    <link rel="stylesheet" href="{{asset('dataTables-1.10.7/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('toastr/css/toastr.min.css')}}">
@endsection
