@extends('layouts.master')
<?php use App\Http\Controllers\UserLevelController; ?>
<?php use App\Http\Controllers\MainMenuController; ?>
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        {{ __('lang.sablonbalon.contactUs.view.title') }}
        <small>{{ __('lang.sablonbalon.contactUs.view.subtitle') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('lang.sablonbalon.contactUs.breadcrumb.home') }}</a></li>
        <li><a href="#">{{ __('lang.sablonbalon.contactUs.breadcrumb.sablonbalon') }}</a></li>
        <li class="active">{{ __('lang.sablonbalon.contactUs.breadcrumb.contactUs.view') }}</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('lang.sablonbalon.contactUs.view.title') }}</h3>
            </div>
                <table class="table table-bordered" id="contact-table">
                    <thead>
                        <tr>
                            <th>{{ __('lang.sablonbalon.contactUs.view.table.id') }}</th>
                            <th>{{ __('lang.sablonbalon.contactUs.view.table.name') }}</th>
                            <th>{{ __('lang.sablonbalon.contactUs.view.table.email') }}</th>
                            <th>{{ __('lang.sablonbalon.contactUs.view.table.message') }}</th>
                            <th>{{ __('lang.sablonbalon.contactUs.view.table.action') }}</th>
                        </tr>
                    </thead>
                </table>
          </div>

        </div>
      </div>
    </section>
  </div>

        <!-- Modal form to edit a form -->
    <div id="viewModal" class="modal fade" role="dialog">
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
                          <label for="name">{{ __('lang.sablonbalon.contactUs.view.table.name') }} </label>
                          <input disabled="true" type="text" name="name" class="form-control" id="editName"
                          placeholder="{{ __('lang.sablonbalon.contactUs.view.table.name') }}">
                          <p class="errorEditName text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="email">{{ __('lang.sablonbalon.contactUs.view.table.email') }} </label>
                          <input disabled="true" type="text" name="email" class="form-control" id="editEmail"
                          placeholder="{{ __('lang.sablonbalon.contactUs.view.table.email') }}">
                          <p class="errorEditEmail text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="phoneNo">{{ __('lang.sablonbalon.contactUs.view.table.phoneNo') }} </label>
                          <input disabled="true" type="text" name="phoneNo" class="form-control" id="editPhoneNo"
                          placeholder="{{ __('lang.sablonbalon.contactUs.view.table.phoneNo') }}">
                          <p class="errorEditPhoneNo text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="subject">{{ __('lang.sablonbalon.contactUs.view.table.subject') }}</label>
                          <input disabled="true" type="text" name="subject" class="form-control" id="editSubject"
                          placeholder="{{ __('lang.sablonbalon.contactUs.view.table.subject') }}">
                          <p class="errorEditSubject text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="message">{{ __('lang.sablonbalon.contactUs.view.table.message') }}</label>
                          <textarea class="form-control" disabled="true" id="editMessage"
                          placeholder="{{ __('lang.sablonbalon.contactUs.view.table.message') }}" name="message" ></textarea>
                          <p class="errorEditMessage text-center alert alert-danger hidden"></p>
                        </div>
                      </div>
                    </form>
                    <div class="modal-footer">
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

        $('#contact-table').DataTable({
            scrollX: true,
            searching: true,
            processing: true,
            serverSide: true,
            ajax: '{!! route('getListContactUsData') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'message', name: 'message' },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ],
       });
    });

    </script>
      <script type="text/javascript">
      // function hiddenErrorEdit() {
      //   $('.errorEditSettingDesc').addClass('hidden');
      //   $('.errorEditSettingName').addClass('hidden');
      //   $('.errorEditSettingValue').addClass('hidden');
      //   $('.errorEditMessage').addClass('hidden');
      // };
      function view(contactId) {
        $.ajax({
            type: 'GET',
            url: '{{ url( '/ContactUs/showView' ) }}',
            data: {
              'id': contactId
            },
            success: function(data) {
              // hiddenErrorEdit();
              $('#editId').val(data[0].id);
              $('#editName').val(data[0].name);
              $('#editEmail').val(data[0].email);
              $('#editPhoneNo').val(data[0].phoneNo);
              $('#editSubject').val(data[0].subject);
              $('#editMessage').val(data[0].message);
              $('#viewModal').modal('show');

            },
        });
      }
      // function RefreshTable(tableId, urlData){
      //   $.getJSON(urlData, null, function( json )
      //   {
      //     table = $(tableId).dataTable();
      //     oSettings = table.fnSettings();
      //     table.fnClearTable(this);
      //     oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
      //     table.fnDraw();
      //   });
      // }
      // $('.modal-footer').on('click', '.edit', function() {
      //   hiddenErrorEdit();
      //     $.ajax({
      //         type: 'POST',
      //         url: '{{ url( '/SysSetting/editProcess' ) }}',
      //         data: {
      //             '_token': $('input[name=_token]').val(),
      //             'id': $('#editId').val(),
      //             'settingValue': $('#editSettingValue').val()
      //
      //         },
      //         success: function(data) {
      //           hiddenErrorEdit();
      //
      //             if (data.rc!=0) {
      //
      //                 if (data.message) {
      //                     $('.errorEditMessage').removeClass('hidden');
      //                     $('.errorEditMessage').text(data.message);
      //                 }
      //                 if (data.errors.settingDesc) {
      //                     $('.errorEditSettingDesc').removeClass('hidden');
      //                     $('.errorEditSettingDesc').text(data.errors.settingDesc[0]);
      //                 }
      //                 if (data.errors.settingName) {
      //                     $('.errorEditSettingName').removeClass('hidden');
      //                     $('.errorEditSettingName').text(data.errors.settingName);
      //                 }
      //                 if (data.errors.settingValue) {
      //                     $('.errorEditSettingValue').removeClass('hidden');
      //                     $('.errorEditSettingValue').text(data.errors.settingValue);
      //                 }
      //
      //             } else {
      //                 $('#viewModal').modal('hide');
      //                 toastr.success(data.message, 'Success Alert', {timeOut: 2000});
      //                 RefreshTable('#contact-table','{!! route('getListSystemSettingData') !!}');
      //             }
      //         },
      //         error: function(request, status, err) {
      //             if (status == "timeout") {
      //                 $('.errorEditMessage').removeClass('hidden');
      //                 $('.errorEditMessage').text('{{ __('lang.msg.ajax.timeout') }}');
      //             } else {
      //                 $('.errorEditMessage').removeClass('hidden');
      //                 $('.errorEditMessage').text("error: " + request + status + err);
      //             }
      //         },
      //         timeout: 10000
      //     });
      // });
      </script>

@endsection
@section('cssSelect2')
    <link rel="stylesheet" href="{{asset('dataTables-1.10.7/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('toastr/css/toastr.min.css')}}">
@endsection
