<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TaskController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function ExecuteTask1(Request $request)
    {
        $tableName = 'foods';
        $select = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$tableName."'";
        $columns = DB::select($select);
        $tmp = DB::table($tableName)->get();
        foreach ($tmp as $valueFood) {
            if($valueFood->profit != 0) continue;
            $profit = $valueFood->sell_price;
            $numProducts = DB::table($tableName)->where('foods.id','=',$valueFood->id)->join('food_products','foods.id','=','food_products.id_food')->get();
            foreach ($numProducts as $valueProducts) {
                $buyPrice = DB::table('products')->where('food_products.id','=',$valueProducts->id)->join('food_products','products.id','=','food_products.id_products')->select('products.buy_price')->get();
                foreach ($buyPrice as $value) {
                    $profit -= $valueProducts->count * $value->buy_price;
                }
            }
            $worker = DB::table($tableName)->where('foods.id','=',$valueFood->id)->join('worker','foods.id_worker','=','worker.id')->first();
            if ($valueFood->cooking_time % 60 != 0){
                $time = (int)($valueFood->cooking_time / 60) + 1;
            }
            else{
                $time = (int)($valueFood->cooking_time / 60);
            }
            $profit -= $worker->wages_per_hour * $time;
            $addValue['profit'] = $profit;
            DB::table($tableName)->where('foods.id','=',$valueFood->id)->update($addValue);
        }
        $content = DB::table($tableName)->whereBetween('date_of_cooking', [$request->input('from'),$request->input('until')])->orderBy('profit','desc')->simplePaginate(10);
        return view('task/show', ['table' => $content, 'columns' => $columns, 'show' => false]);
    }

    public function ExecuteTask2(Request $request)
    {
        $id = $request->input('id');
        $food = DB::table('food')->whereBetween('date_of_cooking', [$request->input('from'),$request->input('until')])->where('id_worker', '=', $id)->get();
        $worker = DB::table('worker')->where('id','=',$id)->first();
        $wages = 0;
        foreach ($food as $valueFood) {
            if ($valueFood->cooking_time % 60 != 0){
                $time = (int)($valueFood->cooking_time / 60) + 1;
            }
            else{
                $time = (int)($valueFood->cooking_time / 60);
            }
            $wages += $time * $worker->wages_per_hour;
        }
        return view('task/wages', ['id' => $id, 'wages'=> $wages]);
    }
}
