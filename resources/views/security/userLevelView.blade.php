@extends('layouts.master')
<?php use App\Http\Controllers\UserLevelController; ?>
<?php use App\Http\Controllers\MainMenuController; ?>
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        {{ __('lang.userLevel.view.title') }}
        <small>{{ __('lang.userLevel.view.subtitle') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('lang.user.breadcrumb.home') }}</a></li>
        <li><a href="#">{{ __('lang.user.breadcrumb.security') }}</a></li>
        <li class="active">{{ __('lang.userLevel.breadcrumb.userLevel.view') }}</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('lang.userLevel.view.title') }}</h3>
              <button type="button" data-toggle="modal" onclick="hiddenError()" data-target="#modal-add"
              class="btn btn-primary">{{ __('lang.button.add.new.userLevel') }}</button>
            </div>
                <table class="table table-bordered" id="users-table">
                    <thead>
                        <tr>
                            <th>{{ __('lang.userLevel.view.table.id') }}</th>
                            <th>{{ __('lang.userLevel.view.table.levelName') }}</th>
                            <th>{{ __('lang.userLevel.view.table.levelDesc') }}</th>
                            <th>{{ __('lang.userLevel.view.table.action') }}</th>
                        </tr>
                    </thead>
                </table>
          </div>

        </div>
      </div>
    </section>
  </div>
  <div class="modal js-loading-bar">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-body">
         <div class="progress">
           <div class="indeterminate"></div>
         </div>
       </div>
     </div>
   </div>
  </div>

  <div class="modal fade" id="modal-add">
          <div class="modal-dialog-full">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ __('lang.button.add.new.userLevel') }}</h4>
              </div>
              <div class="modal-body">
                <div class="box box-primary">
                  <form>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                    <div class="box-body">
                      <div class="form-group">
                        <p class="errorMessage text-center alert alert-danger hidden"></p>
                        <label for="levelName">{{ __('lang.userLevel.label.levelName') }} *</label>
                        <input type="text" name="levelName" class="form-control" id="levelName" placeholder="{{ __('lang.userLevel.label.levelName') }}">
                        <p class="errorLevelName text-center alert alert-danger hidden"></p>
                      </div>
                      <div class="form-group">
                        <label for="levelDesc">{{ __('lang.userLevel.label.levelDesc') }} *</label>
                        <input type="text" name="levelDesc" class="form-control" id="levelDesc" placeholder="{{ __('lang.userLevel.label.levelDesc') }}">
                        <p class="errorLevelDesc text-center alert alert-danger hidden"></p>
                      </div>
                      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List Menu *</h3>
              <p class="errorMenuId text-center alert alert-danger hidden"></p>
            </div>
            <!-- /.box-header -->
            <?php $headerMenus = UserLevelController::listHeaderMenu(); ?>
            <div id="checkboxesAdd">
            @foreach($headerMenus as $headerMenu)
              <div class="col-md-4">
              <div class="box-body">
                <table class="table table-striped">
                  <tr>
                    <th>{{ $headerMenu->menu_description }}</th>
                    <th style="width: 10px">Access</th>
                  </tr>
                  <?php $detailMenus = UserLevelController::listDetailMenu($headerMenu->menu_id); ?>
                  @foreach($detailMenus as $detailMenu)
                      <tr>
                        <td>{{ $detailMenu->menu_description }}</td>
                        <td>
                          @if ($detailMenu->always_include == 1)
                            <input checked type="checkbox" name="menuId[]" value="{{ $detailMenu->menu_id }}" id="menuId">
                          @else
                            <input type="checkbox" name="menuId[]" value="{{ $detailMenu->menu_id }}" id="menuId">
                          @endif
                        </td>
                      </tr>
                  @endforeach
                </table>
                </div>
                </div>
            @endforeach
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

        <input type="checkbox" id="selectAllAdd"> Select All

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
                          <label for="levelName">{{ __('lang.userLevel.label.levelName') }} *</label>
                          <input type="text" name="levelName" class="form-control" id="editLevelName" placeholder="{{ __('lang.userLevel.label.levelName') }}">
                          <p class="errorEditLevelName text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="form-group">
                          <label for="levelDesc">{{ __('lang.userLevel.label.levelDesc') }} *</label>
                          <input type="text" name="levelDesc" class="form-control" id="editLevelDesc" placeholder="{{ __('lang.userLevel.label.levelDesc') }}">
                          <p class="errorEditLevelDesc text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">List Menu *</h3>
                <p class="errorMenuId text-center alert alert-danger hidden"></p>
              </div>
              <!-- /.box-header -->
              <?php $headerMenus = UserLevelController::listHeaderMenu(); ?>
              <div id="checkboxesEdit">
              @foreach($headerMenus as $headerMenu)
                <div class="col-md-4">
                <div class="box-body">
                  <table class="table table-striped">
                    <tr>
                      <th>{{ $headerMenu->menu_description }}</th>
                      <th style="width: 10px">Access</th>
                    </tr>
                    <?php $detailMenus = UserLevelController::listDetailMenu($headerMenu->menu_id); ?>
                    @foreach($detailMenus as $detailMenu)
                        <tr>
                          <td>{{ $detailMenu->menu_description }}</td>
                          <td>
                            @if ($detailMenu->always_include == 1)
                              <input checked type="checkbox" name="menuId[]" value="{{ $detailMenu->menu_id }}" id="menuId">
                            @else
                              <input type="checkbox" name="menuId[]" value="{{ $detailMenu->menu_id }}" id="menuId">
                            @endif
                          </td>
                        </tr>
                    @endforeach
                  </table>
                  </div>
                  </div>
              @endforeach
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>

          <input type="checkbox" id="selectAllEdit"> Select All
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
            ajax: '{!! route('getListUserLevelData') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'level_name', name: 'level_name' },
                { data: 'level_desc', name: 'level_desc' },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ],
       });
    });

    </script>
    <script type="text/javascript">
        function clearInputAdd() {
          $('#levelName').val('');
          $('#levelDesc').val('');
          $('#checkboxesAdd :checkbox').each(function(i,item){
            this.checked = item.defaultChecked;
          });
          $('#selectAllAdd').each(function(i,item){
            this.checked = item.defaultChecked;
          });

        }
        $('#selectAllAdd').click(function() {
          var checked = $(this).prop('checked');
          $('#checkboxesAdd').find('input:checkbox').prop('checked', checked);
        });

        $('#selectAllEdit').click(function() {
          var checked = $(this).prop('checked');
          $('#checkboxesEdit').find('input:checkbox').prop('checked', checked);
        });
        function hiddenError() {
          $('.errorLevelName').addClass('hidden');
          $('.errorLevelDesc').addClass('hidden');
          $('.errorMenuId').addClass('hidden');
          $('.errorMessage').addClass('hidden');

        };
        function hiddenErrorEdit() {
          $('.errorEditLevelName').addClass('hidden');
          $('.errorEditLevelDesc').addClass('hidden');
          $('.errorEditMessage').addClass('hidden');
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
          var menuIds = $('#checkboxesAdd input:checked').map(function(){
              return $(this).val();
              }).get();

            $.ajax({
                type: 'POST',
                url: '{{ url( '/UserLevel/AddAjax' ) }}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'levelName': $('#levelName').val(),
                    'levelDesc': $('#levelDesc').val(),
                    'menuIds': JSON.stringify(menuIds)

                },
                success: function(data) {
                  hiddenError();
                    if (data.rc!=0) {
                        if (data.message) {
                            $('.errorMessage').removeClass('hidden');
                            $('.errorMessage').text(data.message);
                        }
                        if (data.errors.levelName) {
                            $('.errorLevelName').removeClass('hidden');
                            $('.errorLevelName').text(data.errors.levelName[0]);
                        }
                        if (data.errors.levelDesc) {
                            $('.errorLevelDesc').removeClass('hidden');
                            $('.errorLevelDesc').text(data.errors.levelDesc);
                        }
                        if (data.errors.menuIds) {
                            $('.errorMenuId').removeClass('hidden');
                            $('.errorMenuId').text(data.errors.menuIds);
                        }

                    } else {
                        $('#modal-add').modal('hide');
                        toastr.success(data.message, 'Success Alert', {timeOut: 2000});
                        RefreshTable('#users-table','{!! route('getListUserLevelData') !!}');
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
      <script type="text/javascript">
      function edit(levelId) {
        // showProgressBar();
        // progress bar
        // var $modal = $('.js-loading-bar'),
        //     $bar = $modal.find('.progress-bar');
        // $modal.modal('show');
        // $bar.addClass('animate');
        // setTimeout(function() {
        //   $bar.removeClass('animate');
        //   $modal.modal('hide');
        // }, 10000);
        $.ajax({
            type: 'GET',
            url: '{{ url( '/UserLevel/showEdit' ) }}',
            data: {
              'id': levelId
            },
            success: function(data) {
              // progress bar
              // $bar.removeClass('animate');
              // $modal.modal('hide');
              // hideProgressBar();
              // $bar.removeClass('animate');
              // $modal.modal('hide');
              // console.log(' success edit JS');
              hiddenErrorEdit();
              $('#editId').val(data[0].id);
              $('#editLevelName').val(data[0].level_name);
              $('#editLevelDesc').val(data[0].level_desc);
              $('#checkboxesEdit').find('input:checkbox').removeAttr('checked');
              for (var i = 0; i < data.length; i++) {
                  // console.log(data[i].menu_id);
                  $("#checkboxesEdit :checkbox[value="+data[i].menu_id+"]").attr("checked","true");
              }
              // console.log(' success2 edit JS');
              $('#editModal').modal('show');

            },
        });
      }
      $('.modal-footer').on('click', '.edit', function() {
        hiddenErrorEdit();
        // // progress bar
        // var $modal = $('.js-loading-bar'),
        //     $bar = $modal.find('.progress-bar');
        // $modal.modal('show');
        // $bar.addClass('animate');
        // setTimeout(function() {
        //   $bar.removeClass('animate');
        //   $modal.modal('hide');
        // }, 10000);
        var menuIds = $('#checkboxesEdit input:checked').map(function(){
            return $(this).val();
            }).get();
          $.ajax({
              type: 'POST',
              url: '{{ url( '/UserLevel/editProcess' ) }}',
              data: {
                  '_token': $('input[name=_token]').val(),
                  'id': $('#editId').val(),
                  'levelName': $('#editLevelName').val(),
                  'levelDesc': $('#editLevelDesc').val(),
                  'menuIds': JSON.stringify(menuIds)

              },
              success: function(data) {
                // progress bar
                // $bar.removeClass('animate');
                // $modal.modal('hide');
                hiddenErrorEdit();

                  if (data.rc!=0) {

                      if (data.message) {
                          $('.errorEditMessage').removeClass('hidden');
                          $('.errorEditMessage').text(data.message);
                      }
                      if (data.errors.levelName) {
                          $('.errorEditLevelName').removeClass('hidden');
                          $('.errorEditLevelName').text(data.errors.levelName[0]);
                      }
                      if (data.errors.levelDesc) {
                          $('.errorEditLevelDesc').removeClass('hidden');
                          $('.errorEditLevelDesc').text(data.errors.levelDesc);
                      }
                      if (data.errors.menuIds) {
                          $('.errorMenuId').removeClass('hidden');
                          $('.errorMenuId').text(data.errors.menuIds);
                      }

                  } else {
                      $('#editModal').modal('hide');
                      toastr.success(data.message, 'Success Alert', {timeOut: 2000});
                      RefreshTable('#users-table','{!! route('getListUserLevelData') !!}');
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
