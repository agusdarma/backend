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
    // Log::info('Session '.$loginDataJson);
    $loginData2 = $app->make('LoginData');
    $loginData2 = json_decode($loginDataJson);
    // query main menu di fungsi
    return view('home',array('results' => $this->queryMainMenu($loginData2->groupId)));
  }

  public static function queryMainMenu($levelId){
    $results = DB::select('select um.* from user_menu um
    inner join user_level_menu ulm on um.menu_id = ulm.menu_id
    where ulm.level_id = :groupId and um.menu_leaf = 0 order by show_order asc', ['groupId' => $levelId]);
    // Log::info('queryMainMenu ');
    return $results;
  }

  public static function querySubMenu($mainId,$levelId){
    $listSubMenu = DB::select('select um.* from user_menu um
    inner join user_level_menu ulm on um.menu_id = ulm.menu_id
    where um.parent_id = :parentId and um.menu_leaf = 1 and
    ulm.level_id = :groupId
    order by show_order asc', ['parentId' => $mainId, 'groupId' => $levelId]);
    // Log::info('querySubMenu ');
    return $listSubMenu;
  }

  public static function userLogged(){
    $app = app();
    $loginDataJson = session(Constants::CONSTANTS_SESSION_LOGIN());
    $loginData2 = $app->make('LoginData');
    // Log::debug('$loginDataJson'.$loginDataJson);
    $loginData2 = json_decode($loginDataJson);
    return $loginData2->firstName;
  }

  public static function userLevelId(){
    $app = app();
    $loginDataJson = session(Constants::CONSTANTS_SESSION_LOGIN());
    $loginData2 = $app->make('LoginData');
    $loginData2 = json_decode($loginDataJson);
    return $loginData2->groupId;
  }
}
