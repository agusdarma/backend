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
              <button type="submit" data-toggle="modal" data-target="#modal-add"
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
                <h4 class="modal-title">Add User Data</h4>
              </div>
              <div class="modal-body">
                <div class="box box-primary">
                  <form method="post" action="{{ url( '/UserData/Add' ) }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                    <div class="box-body">
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
@endsection
@section('cssSelect2')
    <link rel="stylesheet" href="{{asset('dataTables-1.10.7/css/jquery.dataTables.min.css')}}">
@endsection
