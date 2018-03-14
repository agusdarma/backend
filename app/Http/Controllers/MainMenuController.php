<?php

namespace App\Http\Controllers;
use Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\MessageBag;
use Validator;
class MainMenuController extends Controller
{
  public function MainMenu(Request $request){
    Log::debug('MainMenu');
    $app = app();
    $loginDataJson = session(Constants::CONSTANTS_SESSION_LOGIN());
    Log::info('Session '.$loginDataJson);
    $loginData2 = $app->make('LoginData');
    $loginData2 = json_decode($loginDataJson);
    Log::info('Session2 '.$loginData2->email);
    Log::debug('Group ID '.$loginData2->groupId);
    // query menu main first
    $results = DB::select('select um.* from user_menu um
    inner join user_level_menu ulm on um.menu_id = ulm.menu_id
    where ulm.level_id = :groupId and um.menu_leaf = 0', ['groupId' => $loginData2->groupId]);

    return view('home',array('results' => $results));
  }

  public static function querySubMenu($mainId){
    $listSubMenu = DB::select('select um.* from user_menu um
    inner join user_level_menu ulm on um.menu_id = ulm.menu_id
    where um.parent_id = :parentId and um.menu_leaf = 1', ['parentId' => $mainId]);
    return $listSubMenu;
  }
}
