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
class UserLevelController extends Controller
{

  public function view(Request $request){
    Log::debug('UserLevelController => view()');
    return view('security/userLevelView');
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

  public function addAjax(Request $request){
    Log::debug('UserLevelController => addAjax()');
    // validasi input
    $validator = Validator::make($request->all(), [
            'levelName' => 'required',
            'levelDesc' => 'required',


    ]);
    
    if ($validator->fails()) {
           Log::warn('Error validasi input ');
           $response = array('errors' => $validator->getMessageBag(),
           'rc' => Constants::SYS_RC_VALIDATION_INPUT_ERROR());
             Log::debug(Response::json($response));
           return Response::json($response);
    }
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
    DB::beginTransaction();

    try {
        DB::insert('insert into user_level (level_name, level_desc,created_by,updated_by) values (:levelName,
        :levelDesc, :createdBy, :updatedBy)',
        ['levelName' => $levelName, 'levelDesc' => $levelDesc , 'createdBy' => $createdBy,
         'updatedBy' => $updatedBy]);
        $levelId = DB::getPdo()->lastInsertId();
        foreach ($dataMenuId as $id) {
            DB::insert('insert into user_level_menu (level_id, menu_id) values (:levelId,:menuId)',
            ['levelId' => $levelId, 'menuId' => $id ]);
        }

        DB::commit();
        $response = array('level' => Constants::SYS_MSG_LEVEL_SUCCESS(),
        'message' => Constants::SYS_MSG_USER_LEVEL_SUCCESS_ADDED(),
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

  public function showEdit(Request $request){
    Log::debug('UserLevelController => showEdit()');
    $id = $request->id;
    Log::debug('id => '.$id);
    $listUserLevels = DB::select('select u.id,u.first_name,u.last_name,u.email,u.phone_no,l.level_name,u.gender,u.username
    ,u.store,l.id as level_id,u.status as status
    from users u inner join user_level l on u.group_id = l.id
    where u.id = :id', ['id' => $id]);
    return Response::json($listUserLevels);
  }

  public function editProcess(Request $request){
    Log::debug('UserLevelController => editProcess()');
    // validasi input
    $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'email' => 'required|email',
            'phoneNo' => 'required',
            'userLevel' => 'required',
            'gender' => 'required',

    ]);
    // Jika input gagal redirect ke login page
    if ($validator->fails()) {
           Log::warn('Error validasi input ');
           $response = array('errors' => $validator->getMessageBag(),
           'rc' => Constants::SYS_RC_VALIDATION_INPUT_ERROR());
           return Response::json($response);
    }
    $id = $request->id;
    $firstName = $request->firstName;
    Log::info('First name Input '.$firstName);
    Log::info('Edit ID Input '.$id);
    $lastName = $request->lastName;
    $email = $request->email;
    $phoneNo= $request->phoneNo;
    $userLevel= $request->userLevel;
    $gender= $request->gender;
    $userName= $request->userName;
    $store= $request->store;
    $status= $request->status;
    Log::info('Status input '.$status);
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
      Log::info('mulai edit '.$firstName);
        DB::update('UPDATE users set first_name = :firstName, last_name = :lastName,email = :email,
          phone_no = :phoneNo ,group_id = :userLevel,gender = :gender,username = :userName,
          store = :store,status = :status,updated_by = :updatedBy,updated_at = :updated_at where id = :id',
        ['firstName' => $firstName, 'lastName' => $lastName , 'email' => $email , 'phoneNo' => $phoneNo
        , 'userLevel' => $userLevel, 'gender' => $gender, 'userName' => $userName, 'store' => $store
        , 'status' => $status ,'updatedBy' => $updatedBy,'id' => $id,'updated_at' => $updated_at]);
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

}
