<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', ['message' => 'You are logged in!']);
    }

    public function show(Request $request)
    {
        $tableName = $request->input('tableName');
        $select = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$tableName."'";
        $columns = DB::select($select);
        $content = DB::table($tableName)->simplePaginate(10);
        //$content = Product::all();
        return view('task/show', ['table' => $content, 'columns' => $columns, 'tableName' => $tableName, 'show' => true]);
    }

    public function task1()
    {
        return view('task/task1');
    }

     public function task2()
    {
        return view('task/task2');
    }
}
