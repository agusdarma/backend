<?php
namespace App\Handlers\Events;
use App\Events\StudentAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleNewStudentAdded {
    protected $name;
    
    public function __construct() {
        //
    }
    public function handle(StudentAdded $event) {
        $this->name = $event->name;
        echo "<br>New Student added in database with name: ".$this->name;
    }
}