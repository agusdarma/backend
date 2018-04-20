@extends('layouts.master')
<?php use App\Http\Controllers\UserLevelController; ?>
<?php use App\Http\Controllers\MainMenuController; ?>
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        {{ __('lang.systemSetting.view.title') }}
        <small>{{ __('lang.systemSetting.view.subtitle') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('lang.systemSetting.breadcrumb.home') }}</a></li>
        <li><a href="#">{{ __('lang.systemSetting.breadcrumb.security') }}</a></li>
        <li class="active">{{ __('lang.systemSetting.breadcrumb.systemSetting.view') }}</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('lang.systemSetting.view.title') }}</h3>
            </div>
                <table class="table table-bordered" id="users-table">
                    <thead>
                        <tr>
                            <th>{{ __('lang.systemSetting.view.table.id') }}</th>
                            <th>{{ __('lang.systemSetting.view.table.settingDesc') }}</th>
                            <th>{{ __('lang.systemSetting.view.table.settingName') }}</th>
                            <th>{{ __('lang.systemSetting.view.table.settingValue') }}</th>
                            <th>{{ __('lang.systemSetting.view.table.updatedBy') }}</th>
                            <th>{{ __('lang.systemSetting.view.table.updatedAt') }}</th>
                            <th>{{ __('lang.systemSetting.view.table.action') }}</th>
                        </tr>
                    </thead>
                </table>
          </div>

        </div>
      </div>
    </section>
  </div>

        <!-- Modal form to edit a form -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog-full">
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
                          <label for="settingDesc">{{ __('lang.systemSetting.view.table.settingDesc') }} *</label>
                          <input disabled="true" type="text" name="settingDesc" class="form-control" id="editSettingDesc" placeholder="{{ __('lang.systemSetting.view.table.settingDesc') }}">
                          <p class="errorEditSettingDesc text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="settingName">{{ __('lang.systemSetting.view.table.settingName') }} *</label>
                          <input disabled="true" type="text" name="settingName" class="form-control" id="editSettingName" placeholder="{{ __('lang.systemSetting.view.table.settingName') }}">
                          <p class="errorEditSettingName text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="settingValue">{{ __('lang.systemSetting.view.table.settingValue') }} *</label>
                          <input type="text" name="settingValue" class="form-control" id="editSettingValue" placeholder="{{ __('lang.systemSetting.view.table.settingValue') }}">
                          <p class="errorEditSettingValue text-center alert alert-danger hidden"></p>
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
            ajax: '{!! route('getListSystemSettingData') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'setting_desc', name: 'setting_desc' },
                { data: 'setting_name', name: 'setting_name' },
                { data: 'setting_value', name: 'setting_value' },
                { data: 'first_name', name: 'first_name' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ],
       });
    });

    </script>
      <script type="text/javascript">
      function hiddenErrorEdit() {
        $('.errorEditSettingDesc').addClass('hidden');
        $('.errorEditSettingName').addClass('hidden');
        $('.errorEditSettingValue').addClass('hidden');
        $('.errorEditMessage').addClass('hidden');
      };
      function edit(levelId) {
        $.ajax({
            type: 'GET',
            url: '{{ url( '/SysSetting/showEdit' ) }}',
            data: {
              'id': levelId
            },
            success: function(data) {
              hiddenErrorEdit();
              $('#editId').val(data[0].id);
              $('#editSettingDesc').val(data[0].setting_desc);
              $('#editSettingName').val(data[0].setting_name);
              $('#editSettingValue').val(data[0].setting_value);
              $('#editModal').modal('show');

            },
        });
      }
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
      $('.modal-footer').on('click', '.edit', function() {
          $.ajax({
              type: 'POST',
              url: '{{ url( '/SysSetting/editProcess' ) }}',
              data: {
                  '_token': $('input[name=_token]').val(),
                  'id': $('#editId').val(),
                  'settingValue': $('#editSettingValue').val()

              },
              success: function(data) {
                hiddenErrorEdit();

                  if (data.rc!=0) {

                      if (data.message) {
                          $('.errorEditMessage').removeClass('hidden');
                          $('.errorEditMessage').text(data.message);
                      }
                      if (data.errors.settingDesc) {
                          $('.errorEditSettingDesc').removeClass('hidden');
                          $('.errorEditSettingDesc').text(data.errors.settingDesc[0]);
                      }
                      if (data.errors.settingName) {
                          $('.errorEditSettingName').removeClass('hidden');
                          $('.errorEditSettingName').text(data.errors.settingName);
                      }
                      if (data.errors.settingValue) {
                          $('.errorEditSettingValue').removeClass('hidden');
                          $('.errorEditSettingValue').text(data.errors.settingValue);
                      }

                  } else {
                      $('#editModal').modal('hide');
                      toastr.success(data.message, 'Success Alert', {timeOut: 2000});
                      RefreshTable('#users-table','{!! route('getListSystemSettingData') !!}');
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
