@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                	@if ( $show )
	                	<div style="margin-bottom: 10px">
	                		<a href="/remove/{{ $tableName }}" style="margin-right: 10px">Удалить</a>
		                	<a href="/add/{{ $tableName }}" style="margin-right: 10px">Добавить</a>
		                	<a href="/edit/{{ $tableName }}">Изменить</a>
	                	</div>
                	@endif
                    <table>
						<thead>
							<tr>
								@foreach ($columns as $column)
									<th style="padding-right: 20px">
										{{ $column->column_name }}
									</th>
								@endforeach
							</tr>
						</thead>
						@foreach ($table as $row)
						<tr>
							@foreach ($row as $cell)
								<td>
									{{ $cell }}
								</td>
							@endforeach
						</tr>
				    	@endforeach
					</table>
					{{ $table->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection