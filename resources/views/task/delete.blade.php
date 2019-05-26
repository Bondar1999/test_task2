@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Параметры:</div>
                <div class="panel-body">
                	<form action="/remove/byId/{{ $tableName }}" method="POST">
                		{{ csrf_field() }}
                        {{ method_field('PUT') }}
                		<p>
                			Введите id для таблицы {{ $tableName }}: 
	                		<input type="text" name="id">
	                	</p>	
	                	<p>
	                		<button type="submit">
	                			Удалить
	                		</button>
	                	</p>
                	</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection