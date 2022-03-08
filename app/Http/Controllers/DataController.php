<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function fetchData(){
        $files = glob(storage_path() . '/jsonFiles/*.json');
        $newDataArray = [];
        foreach($files as $file){
            $thisData = file_get_contents($file);
            $thisDataArray = json_decode($thisData);
            $newDataArray[] = $thisDataArray;
        }   
        return $newDataArray;
    }

    public function list(){
        $files = $this->fetchData();
        $newDataArray1 = [];
        foreach($files as $file){
            if(!in_array($file->survey->code, $newDataArray1)){
                $newDataArray1[] = $file->survey->code;
            }
        }
        return view('welcome',compact('newDataArray1'));
    }

    public function show(Request $request){
        $files = $this->fetchData();
        $newDataArray1 = [];
        foreach($files as $file){
            if($file->survey->code == $request->survey){
                $newDataArray1[] = $file;
            }
        }
        
        $product_arr = [0,0,0,0,0,0];
        $average = 0;
        $j = 0;
        foreach($newDataArray1 as $item){
            $i = 0;
            foreach($item->questions[0]->answer as $value){
                if($value === true){
                    $product_arr[$i]++;
                    $i++;
                }
                if($value === false){ 
                    $i++;
                }
            }
            $j++;
            $average += $item->questions[1]->answer;
        }
        $average = $average/$j;
        return view('item',compact(['product_arr', 'average']));
    }
}
