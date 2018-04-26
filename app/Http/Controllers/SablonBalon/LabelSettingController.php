<?php

namespace App\Http\Controllers\SablonBalon;
use App\Http\Controllers\Controller;
use Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
// use DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\MessageBag;
use Validator;
use Response;
use Carbon;
class LabelSettingController extends Controller
{

  public function view(Request $request){
    Log::debug('LabelSettingController => view()');
    return view('sablonbalon/labelSettingView');
  }

  public static function getListLabelSettingData(){
    $listLabelSetting = DB::select('select ls.id,ls.label_name as labelName,ls.label_value as labelValue
    ,ls.updated_on as updatedOn from label_setting ls');
    return datatables($listLabelSetting)
    ->addColumn('action', function ($listLabelSetting) {
        return '<a href="#" onclick="edit('.$listLabelSetting->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
    })
    ->toJson();
  }

  public function editView(Request $request){
    Log::debug('LabelSettingController => editView()');
    $id = $request->id;
    Log::debug('id => '.$id);
    $listLabelSetting = DB::select('select ls.id,ls.label_name as labelName,ls.label_value as labelValue
    from label_setting ls where ls.id = :id', ['id' => $id]);
    return Response::json($listLabelSetting);
  }

  public function editProcess(Request $request){
    Log::debug('LabelSettingController => editProcess()');
    // validasi input
    $validator = Validator::make($request->all(), [
            'labelName' => 'required',
            'labelValue' => 'required',

    ]);
    // Jika input gagal redirect
    if ($validator->fails()) {
           Log::warn('Error validasi input ');
           $response = array('errors' => $validator->getMessageBag(),
           'rc' => Constants::SYS_RC_VALIDATION_INPUT_ERROR());
           return Response::json($response);
    }
    $labelSettingId = $request->id;
    $labelName = $request->labelName;
    $labelValue = $request->labelValue;
    $app = app();
    $loginDataJson = session(Constants::CONSTANTS_SESSION_LOGIN());
    $loginData2 = $app->make('LoginData');
    $loginData2 = json_decode($loginDataJson);
    $createdBy = $loginData2->id;
    $updatedBy = $loginData2->id;
    $updatedOn = Carbon\Carbon::now(Constants::ASIA_TIMEZONE());
    Log::info('Update at '.$updatedOn);
    DB::beginTransaction();

    try {
        // update label_setting by id
        DB::update('UPDATE label_setting set label_value = :labelValue
          ,updated_on = :updatedOn, updated_by = :updatedBy where id = :id',
        ['labelValue' => $labelValue,'updatedBy' => $updatedBy,'updatedOn' => $updatedOn ,'id' => $labelSettingId]);

        DB::commit();
        // DB::rollback();
        $response = array('level' => Constants::SYS_MSG_LEVEL_SUCCESS(),
        'message' => Constants::SYS_MSG_LABEL_SETTING_SUCCESS_EDITED(),
        'rc' => '0');
    } catch (\Exception $e) {
        Log::info('error db '.$e->getMessage());
        DB::rollback();
        $response = array('message' => Constants::SYS_MSG_UNKNOWN_ERROR(),
        'rc' => Constants::SYS_RC_UNKNOWN_ERROR(),
        'errors' => '');
    }
    return Response::json($response);
  }


}
