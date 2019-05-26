<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EditTableController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    private function GetCollumns($tableName)
    {
        $select = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$tableName."'";
        $columns = DB::select($select);
        return $columns;
    }

    public function AddRow($tableName)
    {
        $columns = $this->GetCollumns($tableName);
        return view('task/add', ['columns' => $columns, 'tableName' => $tableName]);
    }

    public function InsertIntoTable(Request $request, $tableName)
    {
        $columns = $this->GetCollumns($tableName);
        foreach ($columns as $column) {
            if (($column->column_name == 'id') || ($column->column_name == 'profit')) {
                continue;
            }
            $data[$column->column_name] = $request->input($column->column_name);
        }
        DB::table($tableName)->insertGetId($data);
        return view('home', ['message' => 'Запись добавлена']);
    }

    public function DeleteRow($tableName)
    {
        return view('task/delete', ['tableName' => $tableName]);
    }

    public function DeleteRowById(Request $request, $tableName)
    {
        DB::table($tableName)->where('id','=',$request->input('id'))->delete();
        return view('home', ['message' => 'Удаление успешно']);
    }

    public function EditRow($tableName)
    {
        $columns = $this->GetCollumns($tableName);
        return view('task/edit',  ['columns' => $columns, 'tableName' => $tableName]);
    }

    public function EditRowById(Request $request, $tableName)
    {
        $select = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$tableName."'";
        $columns = DB::select($select);
        foreach ($columns as $column) {
            if ($column->column_name == 'id') {
                continue;
            }
            $data[$column->column_name] = $request->input($column->column_name);
        }
        DB::table($tableName)->where('id','=',$request->input('id'))->update($data);
        return view('home',  ['message' => 'Изменение успешно']);
    }
}
