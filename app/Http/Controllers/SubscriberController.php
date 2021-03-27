<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Subscriber;

class SubscriberController extends Controller
{


    public function index(){
        return view('subscriber');
        // $subscribers = Subscriber::all();
        // $allWithOutLuther = [];
        // $getLuther = '';
        // $startWithM = [];
        // foreach($subscribers as $subscriber){
        //    switch ($subscriber) {
        //        case $subscriber->first_name == 'Luther':
        //            $getLuther = $subscriber;
        //            break;
        //        case $subscriber->first_name !== 'Luther':
        //             array_push($allWithOutLuther, $subscriber);
        //             break;
        //        case str_starts_with($subscriber->first_name, 'M'):
        //             array_push($startWithM, $subscriber);
        //             break;
        //        default:
                   
        //         //    break;
        //    }
        // }
        // dd($getLuther,$allWithOutLuther, $startWithM);
        
    }

    public function search(Request $request){
        $fieldName = $request->field_name;
        $logic = $request->normal_logic;
        $dateLogic = $request->date_logic;
        $value = $request->value;
        $value2 = $request->value2;
        if(isset($logic)){
            switch($logic){
                case $logic === '=' || $logic === '!=':
                    $subscribers = DB::select("SELECT * FROM subscribers WHERE $fieldName $logic'$value'"); 
                    return response()->json(['subscribers' => $subscribers], 200);
                    break;
                case $logic !== '=' && $logic !== '!=' && $logic !== 'LIKE' && $logic !== 'NOT LIKE': 
                    $subscribers = DB::select("SELECT * FROM subscribers WHERE $logic($fieldName, 1) = '$value'"); 
                    return response()->json(['subscribers' => $subscribers], 200);
                    break;
                case $logic === 'LIKE' || $logic === 'NOT LIKE':  
                    $subscribers = DB::select("SELECT * FROM subscribers WHERE $fieldName $logic '%$value%'"); 
                    return response()->json(['subscribers' => $subscribers], 200);
                    break;       
            }
        }
        if($dateLogic){
            switch($dateLogic){
                case $dateLogic !== 'BETWEEN':
                    $subscribers = DB::select("SELECT * FROM subscribers WHERE $fieldName $dateLogic '$value'"); 
                    return response()->json(['subscribers' => $subscribers], 200);
                    break;
                case $dateLogic === 'BETWEEN':
                    $subscribers = DB::select("SELECT * FROM subscribers WHERE $fieldName $dateLogic '$value' AND '$value2'"); 
                    return response()->json(['subscribers' => $subscribers], 200);
                    break;
            }
        }

    }
}
