<?php

namespace App\Http\Controllers;
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
class ProfileSettingController extends Controller
{

  public function view(Request $request){
    Log::debug('ProfileSettingController => view()');
    return view('security/profileSettingView');
  }

  public function upload(Request $request){
    Log::debug('ProfileSettingController => upload()');
    $validator = Validator::make($request->all(), [
      'newImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
           Log::warn('Error validasi input ');
           $response = array('errors' => $validator->getMessageBag(),
           'rc' => Constants::SYS_RC_VALIDATION_INPUT_ERROR());
           Log::error(Response::json($response));
           return Response::json($response);
    }
      // $newImage = $request->newImage;
      // $settingValue = $request->settingValue;
      // Log::debug('$settingValue => $settingValue()'.$settingValue);
      // $newImage = 'avatar5.'.$request->newImage->getClientOriginalExtension();
      $newImage = 'avatar5.png';
      // $input = $request->all();
      // $input['image'] = time().'.'.$request->image->getClientOriginalExtension();
      $request->newImage->move(public_path('images'), $newImage);
      //
      // AjaxImage::create($input);

      // return response()->json(['success'=>'done']);
      $response = array('level' => Constants::SYS_MSG_LEVEL_SUCCESS(),
      'message' => Constants::SYS_MSG_PROFILE_SETTING_SUCCESS_EDITED(),
      'rc' => '0');
      // Log::debug(Response::json($response));
      return Response::json($response);

  }


}
