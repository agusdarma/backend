@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        {{ __('lang.sablonbalon.labelSetting.view.title') }}
        <small>{{ __('lang.sablonbalon.labelSetting.view.subtitle') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('lang.sablonbalon.labelSetting.breadcrumb.home') }}</a></li>
        <li><a href="#">{{ __('lang.sablonbalon.labelSetting.breadcrumb.sablonbalon') }}</a></li>
        <li class="active">{{ __('lang.sablonbalon.labelSetting.breadcrumb.labelSetting.view') }}</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('lang.sablonbalon.labelSetting.view.title') }}</h3>
            </div>
                <table class="table table-bordered" id="label-table">
                    <thead>
                        <tr>
                            <th>{{ __('lang.sablonbalon.labelSetting.view.table.id') }}</th>
                            <th>{{ __('lang.sablonbalon.labelSetting.view.table.labelName') }}</th>
                            <th>{{ __('lang.sablonbalon.labelSetting.view.table.labelValue') }}</th>
                            <th>{{ __('lang.sablonbalon.labelSetting.view.table.updatedOn') }}</th>
                            <th>{{ __('lang.sablonbalon.labelSetting.view.table.action') }}</th>
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
                          <label for="labelName">{{ __('lang.sablonbalon.labelSetting.view.table.labelName') }} </label>
                          <input disabled="true" type="text" name="labelName" class="form-control" id="editLabelName"
                          placeholder="{{ __('lang.sablonbalon.labelSetting.view.table.labelName') }}">
                          <p class="errorLabelName text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="labelValue">{{ __('lang.sablonbalon.labelSetting.view.table.labelValue') }} </label>
                          <input type="text" name="labelValue" class="form-control" id="editLabelValue"
                          placeholder="{{ __('lang.sablonbalon.labelSetting.view.table.labelValue') }}">
                          <p class="errorLabelValue text-center alert alert-danger hidden"></p>
                        </div>
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

        $('#label-table').DataTable({
            scrollX: true,
            searching: true,
            processing: true,
            serverSide: true,
            ajax: '{!! route('getListLabelSettingData') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'labelName', name: 'labelName' },
                { data: 'labelValue', name: 'labelValue' },
                { data: 'updatedOn', name: 'updatedOn' },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ],
       });
    });

    </script>
      <script type="text/javascript">
      function hiddenErrorEdit() {
        $('.errorLabelName').addClass('hidden');
        $('.errorLabelValue').addClass('hidden');
      };
      function edit(labelId) {
        $.ajax({
            type: 'GET',
            url: '{{ url( '/LblSetting/editView' ) }}',
            data: {
              'id': labelId
            },
            success: function(data) {
              hiddenErrorEdit();
              $('#editId').val(data[0].id);
              $('#editLabelName').val(data[0].labelName);
              $('#editLabelValue').val(data[0].labelValue);
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
        hiddenErrorEdit();
          $.ajax({
              type: 'POST',
              url: '{{ url( '/LblSetting/editProcess' ) }}',
              data: {
                  '_token': $('input[name=_token]').val(),
                  'id': $('#editId').val(),
                  'labelName': $('#editLabelName').val(),
                  'labelValue': $('#editLabelValue').val()

              },
              success: function(data) {
                hiddenErrorEdit();

                  if (data.rc!=0) {

                      if (data.message) {
                          $('.errorEditMessage').removeClass('hidden');
                          $('.errorEditMessage').text(data.message);
                      }
                      if (data.errors.labelName) {
                          $('.editLabelName').removeClass('hidden');
                          $('.editLabelName').text(data.errors.labelName[0]);
                      }
                      if (data.errors.labelValue) {
                          $('.editLabelValue').removeClass('hidden');
                          $('.editLabelValue').text(data.errors.labelValue);
                      }

                  } else {
                      $('#editModal').modal('hide');
                      toastr.success(data.message, 'Success Alert', {timeOut: 2000});
                      RefreshTable('#label-table','{!! route('getListLabelSettingData') !!}');
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
