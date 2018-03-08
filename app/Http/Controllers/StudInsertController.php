<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class StudInsertController extends Controller
{
    public function insertform(){
        Log::debug('Showing user profile for user: ');
        return view('stud_create');
    }
    
    public function insert(Request $request){
        $name = $request->input('stud_name');
        DB::insert('insert into student (name) values(?)',[$name]);
        echo "Record inserted successfully.<br/>";
        echo '<a href = "/insert">Click Here</a> to go back.';
        Log::debug('Domne ');
    }
}
