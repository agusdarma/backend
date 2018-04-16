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
class ChangePasswordController extends Controller
{

  public function view(Request $request){
    Log::debug('ChangePasswordController => view()');
    return view('security/ChangePassword');
  }

  public static function getListUserLevelData(){
    $listUserLevels = DB::select('select l.id,l.level_name,l.level_desc
    from user_level l');
    return datatables($listUserLevels)
    ->addColumn('action', function ($listUserLevels) {
        return '<a href="#" onclick="edit('.$listUserLevels->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
    })
    ->toJson();
  }

  public function change(Request $request){
    Log::debug('ChangePasswordController => change()');
    // validasi input
    $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confirmPassword' => 'required',

    ]);

    if ($validator->fails()) {
           Log::warn('Error validasi input ');
           $response = array('errors' => $validator->getMessageBag(),
           'rc' => Constants::SYS_RC_VALIDATION_INPUT_ERROR());
             Log::debug(Response::json($response));
           return Response::json($response);
    }
    $oldPassword = $request->oldPassword;
    $newPassword = $request->newPassword;
    $confirmPassword = $request->confirmPassword;

    $app = app();
    $loginDataJson = session(Constants::CONSTANTS_SESSION_LOGIN());
    $loginData2 = $app->make('LoginData');
    $loginData2 = json_decode($loginDataJson);
    $createdBy = $loginData2->id;
    $updatedBy = $loginData2->id;
    // cari user dari db
    $user = DB::table('users')->where('id', $loginData2->id)->first();
    Log::debug($user);
    if($user->isEmpty()){
      $response = array('errors' => array('message' => Constants::SYS_MSG_USER_NOT_FOUND()),
      'rc' => Constants::SYS_RC_USER_NOT_FOUND());
      Log::debug(Response::json($response));
      return Response::json($response);
    }


    DB::beginTransaction();

    try {




        DB::commit();
        $response = array('level' => Constants::SYS_MSG_LEVEL_SUCCESS(),
        'message' => Constants::SYS_MSG_CHANGE_PASSWORD_SUCCESS_CHANGED(),
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

  public function showEdit(Request $request){
    // sleep(20);
    Log::debug('ChangePasswordController => showEdit()');
    $id = $request->id;
    Log::debug('id => '.$id);
    $listUserLevels = DB::select('select l.id,l.level_name,l.level_desc, um.menu_id
    from user_level l
		inner join user_level_menu ulm on ulm.level_id = l.id
		inner join user_menu um on um.menu_id = ulm.menu_id
    where l.id = :id and um.menu_leaf = 1', ['id' => $id]);
    return Response::json($listUserLevels);
  }

  public function editProcess(Request $request){
    Log::debug('ChangePasswordController => editProcess()');
    // validasi input
    $validator = Validator::make($request->all(), [
            'levelName' => 'required',
            'levelDesc' => 'required',

    ]);
    // Jika input gagal redirect ke login page
    if ($validator->fails()) {
           Log::warn('Error validasi input ');
           $response = array('errors' => $validator->getMessageBag(),
           'rc' => Constants::SYS_RC_VALIDATION_INPUT_ERROR());
           return Response::json($response);
    }
    $levelId = $request->id;
    $levelName = $request->levelName;
    $levelDesc = $request->levelDesc;
    $menuIds = $request->menuIds;
    $dataMenuId = json_decode($menuIds);
    $elementCount  = count($dataMenuId);
    if($elementCount == 0){
      $response = array('errors' => array('menuIds' => Constants::SYS_MSG_MENU_REQUIRED()),
      'rc' => Constants::SYS_RC_VALIDATION_INPUT_ERROR());
      Log::debug(Response::json($response));
      return Response::json($response);
    }
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
        // update user levelId
        DB::update('UPDATE user_level set level_name = :levelName, level_desc = :levelDesc,
          updated_by = :updatedBy,updated_at = :updated_at where id = :id',
        ['levelName' => $levelName, 'levelDesc' => $levelDesc
        ,'updatedBy' => $updatedBy,'id' => $levelId,'updated_at' => $updated_at]);

        // delete all menu with id
        DB::delete('DELETE from user_level_menu where level_id = :id',
        ['id' => $levelId]);

        $listParentId = array();
        // insert menu
        foreach ($dataMenuId as $id) {
          Log::debug('insert menu => '.$id);
            DB::insert('insert into user_level_menu (level_id, menu_id) values (:levelId,:menuId)',
            ['levelId' => $levelId, 'menuId' => $id ]);
            $userMenu = DB::table('user_menu')->where('menu_id', $id)->first();
            array_push($listParentId,$userMenu->parent_id);
        }

        // insert menu header
        foreach (array_unique($listParentId) as $id) {
          Log::debug('insert menu header => '.$id);
            DB::insert('insert into user_level_menu (level_id, menu_id) values (:levelId,:menuId)',
            ['levelId' => $levelId, 'menuId' => $id ]);
        }

        DB::commit();
        // DB::rollback();
        $response = array('level' => Constants::SYS_MSG_LEVEL_SUCCESS(),
        'message' => Constants::SYS_MSG_USER_LEVEL_SUCCESS_EDITED(),
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

  public static function listHeaderMenu(){
    $listHeaderMenu = DB::select('select * from user_menu where menu_leaf = 0');
    return $listHeaderMenu;
  }

  public static function listDetailMenu($headerId){
    $listDetailMenu = DB::select('select * from user_menu where menu_leaf = 1 and parent_id = :headerId',
    ['headerId' => $headerId]);
    return $listDetailMenu;
  }


}
