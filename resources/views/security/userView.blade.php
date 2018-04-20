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
                            <th>{{ __('lang.user.view.table.status') }}</th>
                            <th>{{ __('lang.user.view.table.action') }}</th>
                        </tr>
                    </thead>
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
                        <?php $levels = UserDataController::listUserLevelAll(); ?>
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
                          <option value="male">{{ __('lang.user.label.male') }}</option>
                          <option value="female">{{ __('lang.user.label.female') }}</option>
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

        <!-- Modal form to edit a form -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                      <input type="hidden" name="id" id="editId" >
                      <div class="box-body">
                        <div class="form-group">
                          <p class="errorEditMessage text-center alert alert-danger hidden"></p>
                          <label for="firstName">{{ __('lang.user.label.firstName') }} *</label>
                          <input type="text" name="firstName" class="form-control" id="editFirstName" placeholder="{{ __('lang.user.label.firstName') }}">
                          <p class="errorEditFirstName text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="lastName">{{ __('lang.user.label.lastName') }}</label>
                          <input type="text" name="lastName" class="form-control" id="editLastName" placeholder="{{ __('lang.user.label.lastName') }}">
                          <p class="errorEditLastName text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="email">{{ __('lang.user.label.email') }} *</label>
                          <input type="email" name="email" class="form-control" id="editEmail" placeholder="{{ __('lang.user.label.email') }}">
                          <p class="errorEditEmail text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="phoneNo">{{ __('lang.user.label.phoneNo') }} *</label>
                          <input type="text" name="phoneNo" class="form-control" id="editPhoneNo" placeholder="{{ __('lang.user.label.phoneNo') }}">
                          <p class="errorEditPhoneNo text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <?php $levels = UserDataController::listUserLevelAll(); ?>
                          <label for="userLevel">{{ __('lang.user.label.userLevel') }} *</label>
                          <select id="editUserLevel" name="userLevel" class="form-control select2" style="width: 100%;">
                            @foreach($levels as $level)
                              <option value="{{ $level->id }}">{{ $level->level_name }}</option>
                            @endforeach
                          </select>
                          <p class="errorEditUserLevel text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="gender">{{ __('lang.user.label.gender') }} *</label>
                          <select id="editGender" name="gender" class="form-control select2" style="width: 100%;">
                            <option value="male">{{ __('lang.user.label.male') }}</option>
                            <option value="female">{{ __('lang.user.label.female') }}</option>
                          </select>
                          <p class="errorEditGender text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="userStatus">{{ __('lang.user.label.userStatus') }} *</label>
                          <select id="editUserStatus" name="userStatus" class="form-control select2" style="width: 100%;">
                            <option value="active">{{ __('lang.user.label.active') }}</option>
                            <option value="inactive">{{ __('lang.user.label.inactive') }}</option>
                          </select>
                          <p class="errorEditUserStatus text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="userName">{{ __('lang.user.label.userName') }}</label>
                          <input type="text" name="userName" class="form-control" id="editUserName" placeholder="{{ __('lang.user.label.userName') }}">
                          <p class="errorEditUserName text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="store">{{ __('lang.user.label.store') }}</label>
                          <input type="text" name="store" class="form-control" id="editStore" placeholder="{{ __('lang.user.label.store') }}">
                          <p class="errorEditStore text-center alert alert-danger hidden"></p>
                        </div>
                        <p class="help-block">{{ __('lang.form.required') }}</p>
                      </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary edit" >
                            <span class='glyphicon glyphicon-check'></span> Edit
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
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
            scrollX: true,
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
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ],
       });
    });

    </script>
    <script type="text/javascript">
        function clearInput() {
          $('#firstName').val('');
          $('#lastName').val('');
          $('#email').val('');
          $('#phoneNo').val('');
          $('#userName').val('');
          $('#password').val('');
          $('#store').val('');
        }
        function hiddenError() {
          $('.errorFirstName').addClass('hidden');
          $('.errorEmail').addClass('hidden');
          $('.errorPhoneNo').addClass('hidden');
          $('.errorUserLevel').addClass('hidden');
          $('.errorGender').addClass('hidden');
          $('.errorPassword').addClass('hidden');
          $('.errorMessage').addClass('hidden');

        };
        function hiddenErrorEdit() {
          $('.errorEditFirstName').addClass('hidden');
          $('.errorEditEmail').addClass('hidden');
          $('.errorEditPhoneNo').addClass('hidden');
          $('.errorEditUserLevel').addClass('hidden');
          $('.errorEditGender').addClass('hidden');
          $('.errorEditUserStatus').addClass('hidden');
          $('.errorEditPassword').addClass('hidden');
          $('.errorEditMessage').addClass('hidden');
          console.log('masuk sini4');
        };
        function RefreshTable(tableId, urlData){
          $.getJSON(urlData, null, function( json )
          {
            table = $(tableId).dataTable();
            oSettings = table.fnSettings();
            table.fnClearTable(this);
            oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
            table.fnDraw();
          });
        }
        $('.modal-footer').on('click', '.add', function() {
          hiddenError();
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
                        clearInput();
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
      <script type="text/javascript">
      function edit(userId) {
        $.ajax({
            type: 'GET',
            url: '{{ url( '/UserData/showEdit' ) }}',
            data: {
              'id': userId
            },
            success: function(data) {
              hiddenErrorEdit();
              $('#editId').val(data[0].id);
              $('#editFirstName').val(data[0].first_name);
              $('#editLastName').val(data[0].last_name);
              $('#editEmail').val(data[0].email);
              $('#editPhoneNo').val(data[0].phone_no);
              $("#editUserLevel").val(data[0].level_id);
              $("#editGender").val(data[0].gender);
              $("#editUserStatus").val(data[0].status);
              $('#editUserName').val(data[0].username);
              $('#editStore').val(data[0].store);
              $('#editModal').modal('show');
            },
        });
      }
      $('.modal-footer').on('click', '.edit', function() {
        hiddenErrorEdit();
          $.ajax({
              type: 'POST',
              url: '{{ url( '/UserData/editProcess' ) }}',
              data: {
                  '_token': $('input[name=_token]').val(),
                  'id': $('#editId').val(),
                  'firstName': $('#editFirstName').val(),
                  'lastName': $('#editLastName').val(),
                  'email': $('#editEmail').val(),
                  'phoneNo': $('#editPhoneNo').val(),
                  'userLevel': $('#editUserLevel').val(),
                  'gender': $('#editGender').val(),
                  'status': $('#editUserStatus').val(),
                  'userName': $('#editUserName').val(),
                  'store': $('#editStore').val()



              },
              success: function(data) {
                hiddenErrorEdit();

                  if (data.rc!=0) {

                      if (data.message) {
                          $('.errorEditMessage').removeClass('hidden');
                          $('.errorEditMessage').text(data.message);
                      }
                      if (data.errors.firstName) {
                          $('.errorEditFirstName').removeClass('hidden');
                          $('.errorEditFirstName').text(data.errors.firstName[0]);
                      }
                      if (data.errors.email) {
                          $('.errorEditEmail').removeClass('hidden');
                          $('.errorEditEmail').text(data.errors.email);
                          console.log('masuk sini3');
                      }
                      if (data.errors.phoneNo) {
                          $('.errorEditPhoneNo').removeClass('hidden');
                          $('.errorEditPhoneNo').text(data.errors.phoneNo);
                      }
                      if (data.errors.userLevel) {
                          $('.errorEditUserLevel').removeClass('hidden');
                          $('.errorEditUserLevel').text(data.errors.userLevel);
                      }
                      if (data.errors.gender) {
                          $('.errorEditGender').removeClass('hidden');
                          $('.errorEditGender').text(data.errors.gender);
                      }
                      if (data.errors.status) {
                          $('.errorEditUserStatus').removeClass('hidden');
                          $('.errorEditUserStatus').text(data.errors.status);
                      }
                      if (data.errors.password) {
                          $('.errorEditPassword').removeClass('hidden');
                          $('.errorEditPassword').text(data.errors.password);
                      }
                      console.log('masuk sini2');
                  } else {
                    console.log('masuk sini');
                      $('#editModal').modal('hide');
                      toastr.success(data.message, 'Success Alert', {timeOut: 2000});
                      RefreshTable('#users-table','{!! route('getListUserData') !!}');
                      // clearInput();
                  }
              },
              error: function(request, status, err) {
                  if (status == "timeout") {
                      $('.errorEditMessage').removeClass('hidden');
                      $('.errorEditMessage').text('{{ __('lang.msg.ajax.timeout') }}');
                  } else {
                      $('.errorEditMessage').removeClass('hidden');
                      $('.errorEditMessage').text("error: " + request + status + err);
                  }
              },
              timeout: 10000
          });
      });
      </script>

@endsection
@section('cssSelect2')
    <link rel="stylesheet" href="{{asset('dataTables-1.10.7/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('toastr/css/toastr.min.css')}}">
@endsection
