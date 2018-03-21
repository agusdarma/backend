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
              <button type="button" data-toggle="modal" data-target="#modal-add"
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
                        <label for="firstName">{{ __('lang.user.label.firstName') }} *</label>
                        <input type="text" name="firstName" class="form-control" id="firstName" placeholder="{{ __('lang.user.label.firstName') }}">
                        <p class="errorFirstName text-center alert alert-danger hidden">aloha</p>
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
                        <select id="userLevel" name="userLevel" class="form-control select2" style="width: 100%;">
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
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
@endsection
@section('jsSelect2')
    <script src="{{asset('dataTables-1.10.7/js/jquery.dataTables.min.js')}}"></script>
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
    <!-- AJAX CRUD operations -->
    <script type="text/javascript">
        // add
        $('.modal-footer').on('click', '.add', function() {
          //window.alert( $('#firstName').val());

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
                  // window.alert( data.errors );


                    $('.errorFirstName').addClass('hidden');
                    $('.errorContent').addClass('hidden');
                    if (Object.keys(data.errors).length>0) {
                        // setTimeout(function () {
                        //     $('#addModal').modal('show');
                        //     toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                        // }, 500);
                        if (data.errors.firstName) {
                          console.log("masuk sini");
                          // console.log(data.errors.firstName[0]);

                          // console.log($('.errorfirstName').text());

                            $('.errorFirstName').removeClass('hidden');
                            $('.errorFirstName').text(data.errors.firstName[0]);
                            // $('.modal-title').text(data.errors.firstName[0]);

                        }
                        if (data.errors.content) {
                            $('.errorContent').removeClass('hidden');
                            $('.errorContent').text(data.errors.content);
                        }
                    } else {
                        toastr.success('Successfully added Post!', 'Success Alert', {timeOut: 5000});
                        $('#postTable').prepend("<tr class='item" + data.id + "'><td class='col1'>" + data.id + "</td><td>" + data.title + "</td><td>" + data.content + "</td><td class='text-center'><input type='checkbox' class='new_published' data-id='" + data.id + " '></td><td>Just now!</td><td><button class='show-modal btn btn-success' data-id='" + data.id + "' data-title='" + data.title + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-eye-open'></span> Show</button> <button class='edit-modal btn btn-info' data-id='" + data.id + "' data-title='" + data.title + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-title='" + data.title + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
                        $('.new_published').iCheck({
                            checkboxClass: 'icheckbox_square-yellow',
                            radioClass: 'iradio_square-yellow',
                            increaseArea: '20%'
                        });
                        $('.new_published').on('ifToggled', function(event){
                            $(this).closest('tr').toggleClass('warning');
                        });
                        $('.new_published').on('ifChanged', function(event){
                            id = $(this).data('id');
                            $.ajax({
                                type: 'POST',
                                url: "",
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                    'id': id
                                },
                                success: function(data) {
                                    // empty
                                },
                            });
                        });
                        $('.col1').each(function (index) {
                            $(this).html(index+1);
                        });
                    }
                },
            });
        });

      </script>

@endsection
@section('cssSelect2')
    <link rel="stylesheet" href="{{asset('dataTables-1.10.7/css/jquery.dataTables.min.css')}}">
@endsection
