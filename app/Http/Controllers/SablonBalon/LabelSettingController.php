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

  public static function getListContactUsData(){
    $listContactUs = DB::select('select c.id,c.`name`,c.email,c.message
    from contact c order by c.created_on desc');
    return datatables($listContactUs)
    ->addColumn('action', function ($listContactUs) {
        return '<a href="#" onclick="view('.$listContactUs->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> View</a>';
    })
    ->toJson();
  }

  public function showView(Request $request){
    Log::debug('LabelSettingController => showView()');
    $id = $request->id;
    Log::debug('id => '.$id);
    $listContactUs = DB::select('select c.id,c.`name`,c.email,c.message,c.phone_no as phoneNo, c.subject
    from contact c where c.id = :id', ['id' => $id]);
    return Response::json($listContactUs);
  }

  public function editProcess(Request $request){
    Log::debug('LabelSettingController => editProcess()');
    // validasi input
    $validator = Validator::make($request->all(), [
            'settingValue' => 'required',

    ]);
    // Jika input gagal redirect ke login page
    if ($validator->fails()) {
           Log::warn('Error validasi input ');
           $response = array('errors' => $validator->getMessageBag(),
           'rc' => Constants::SYS_RC_VALIDATION_INPUT_ERROR());
           return Response::json($response);
    }
    $systemSettingId = $request->id;
    $settingValue = $request->settingValue;
    $app = app();
    $loginDataJson = session(Constants::CONSTANTS_SESSION_LOGIN());
    $loginData2 = $app->make('LoginData');
    $loginData2 = json_decode($loginDataJson);
    $createdBy = $loginData2->id;
    $updatedBy = $loginData2->id;
    $invalidCount = 0;
    $updated_at = Carbon\Carbon::now(Constants::ASIA_TIMEZONE());
    Log::info('Update at '.$updated_at);
    DB::beginTransaction();

    try {
        // update system setting by id
        DB::update('UPDATE system_setting set setting_value = :settingValue,
          updated_by = :updatedBy,updated_at = :updated_at where id = :id',
        ['settingValue' => $settingValue,'updatedBy' => $updatedBy,'id' => $systemSettingId,'updated_at' => $updated_at]);

        DB::commit();
        // DB::rollback();
        $response = array('level' => Constants::SYS_MSG_LEVEL_SUCCESS(),
        'message' => Constants::SYS_MSG_SYSTEM_SETTING_SUCCESS_EDITED(),
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
