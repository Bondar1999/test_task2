<?php

Route::get('/', function () {
	return view('main');
});

Route::post('/registration', function (){
	return view('auth/register');
});

Route::post('/authorization', function (){
	return view('auth/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::any('/worker', function(){
	return view('task/worker/editing_worker');
});

Route::any('/show', function(){
	$tableName = $_GET['tableName'];
	$select = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$tableName."'";
	$columns = DB::select($select);
	$content = DB::table($tableName)->simplePaginate(10);
	return view('task/show', ['table' => $content, 'columns' => $columns, 'tableName' => $tableName, 'show' => true]);
});

Route::get('/add/{tableName}', function($tableName){
	$select = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$tableName."'";
	$columns = DB::select($select);
	return view('task/add', ['columns' => $columns, 'tableName' => $tableName]);
});

Route::post('/insert/{tableName}', function($tableName){
	$select = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$tableName."'";
	$columns = DB::select($select);
	foreach ($columns as $column) {
		if (($column->column_name == 'id') || ($column->column_name == 'profit')) {
			continue;
		}
		$data[$column->column_name] = $_POST[$column->column_name];
	}
	DB::table($tableName)->insertGetId($data);
	return view('home', ['message' => 'Запись добавлена']);
});

Route::any('/remove/{tableName}', function($tableName){
	return view('task/delete', ['tableName' => $tableName]);
});

Route::any('remove/byId/{tableName}', function($tableName){
	DB::table($tableName)->where('id','=',$_POST['id'])->delete();
	return view('home', ['message' => 'Удаление успешно']);
});

Route::any('/edit/{tableName}', function($tableName){
	$select = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$tableName."'";
	$columns = DB::select($select);
	return view('task/edit',  ['columns' => $columns, 'tableName' => $tableName]);
});

Route::any('/update/{tableName}', function($tableName){
	$select = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$tableName."'";
	$columns = DB::select($select);
	foreach ($columns as $column) {
		if ($column->column_name == 'id') {
			continue;
		}
		$data[$column->column_name] = $_POST[$column->column_name];
	}
	DB::table($tableName)->where('id','=',$_POST['id'])->update($data);
	return view('home',  ['message' => 'Изменение успешно']);
});

Route::get('/task1', function(){
	return view('task/task1');
});

Route::post('/task1/search', function(){
	$tableName = 'food';
	$select = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$tableName."'";
	$columns = DB::select($select);
	$tmp = DB::table($tableName)->get();
	foreach ($tmp as $valueFood) {
		if($valueFood->profit != 0) continue;
		$profit = $valueFood->sell_price;
		$numProducts = DB::table('food')->where('food.id','=',$valueFood->id)->join('food_products','food.id','=','food_products.id_food')->get();
		foreach ($numProducts as $valueProducts) {
			$buyPrice = DB::table('products')->where('food_products.id','=',$valueProducts->id)->join('food_products','products.id','=','food_products.id_products')->select('products.buy_price')->get();
			foreach ($buyPrice as $value) {
				$profit -= $valueProducts->count * $value->buy_price;
			}
		}
		$worker = DB::table('food')->where('food.id','=',$valueFood->id)->join('worker','food.id_worker','=','worker.id')->first();
		if ($valueFood->cooking_time % 60 != 0){
			$time = (int)($valueFood->cooking_time / 60) + 1;
		}
		else{
			$time = (int)($valueFood->cooking_time / 60);
		}
		$profit -= $worker->wages_per_hour * $time;
		$addValue['profit'] = $profit;
		DB::table('food')->where('food.id','=',$valueFood->id)->update($addValue);
	}
	$content = DB::table($tableName)->whereBetween('date_of_cooking', [$_POST['from'],$_POST['until']])->orderBy('profit','desc')->simplePaginate(10);
	return view('task/show', ['table' => $content, 'columns' => $columns, 'show' => false]);
});

Route::get('/task2', function(){
	return view('task/task2');
});

Route::post('task2/search', function(){
	$food = DB::table('food')->whereBetween('date_of_cooking', [$_POST['from'],$_POST['until']])->where('id_worker', '=', $_POST['id'])->get();
	$worker = DB::table('worker')->where('id','=',$_POST['id'])->first();
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
	return view('task/wages', ['id' => $_POST['id'], 'wages'=> $wages]);
});