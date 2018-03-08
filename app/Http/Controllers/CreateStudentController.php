<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateStudentController extends Controller
{
    public function insertform(){
        return view('stud_create');
    }
    
    public function insert(Request $request){
        $name = $request->input('stud_name');
        DB::insert('insert into student (name) values(?)',[$name]);
        echo "Record inserted successfully.<br/>";
        echo '<a href = "/event">Click Here</a> to go back.';
        
        //firing an event
        Event::fire(new StudentAdded($name));
    }
}
