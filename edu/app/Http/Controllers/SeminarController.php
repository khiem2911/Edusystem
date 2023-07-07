<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
Use Exception;
class SeminarController extends Controller
{
    public function addSeminar(Request $request) {
        $name = $request->name;
        $content = $request->content;
        $timestart =$request->timestart;
        $query=false;
        $alert=false;
        $values = array('name' => $name,'content' => $content,'time-start'=>$timestart);
        try{
          $query=DB::table('Seminar')->insert($values);
        }catch(Exception)
        {
           $alert = alert()->error('Failed','Kiểm tra lại các ô nhập');
           $request->flash();
        }
        if($query)
        {
            alert()->success('Successed');
            return view('welcome');
        }
        if($alert)
        {
            return redirect()->route('home', ['alert' => $alert]);
        }
    }
    public function deleteAllSeminar(){

    }
    public function deleteSeminar(){

    }
    public function editSeminar(){

    }
    public function loadData(){
        $data = DB::select('select * from Seminar');
        return view("welcome");
    }
}
