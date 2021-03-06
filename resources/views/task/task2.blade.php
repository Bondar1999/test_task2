@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Параметры:</div>
                <div class="panel-body">
                	<form action="/task2/search" method="POST">
                		{{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <p>
                            id сотрудника: 
                            <input type="text" name="id">
                        </p>
                		<p>
                            Период от 
                			<input type="date" name="from">
                			До 
                			<input type="date" name="until">
                		</p>
						<button type="submit">
							Посмотреть
						</button>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection