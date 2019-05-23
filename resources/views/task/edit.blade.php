@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Параметры:</div>
                <div class="panel-body">
                	<form action="/update/{{ $tableName }}" method="POST">
                        {{ csrf_field() }}
                        <table>
                            @foreach ($columns as $column)
                                <tr>
                                    @if ($column->column_name != 'id')
                                        <td style="padding-bottom: 20px; padding-right: 10px">{{ $column->column_name }}</td>
                                        <td style="padding-bottom: 20px"><input type="text" name="{{ $column->column_name }}"></td>
                                    @else
                                        <td style="padding-bottom: 20px; padding-right: 10px">{{ $column->column_name }} изменяемой записи</td>
                                        <td style="padding-bottom: 20px"><input type="text" name="{{ $column->column_name }}"></td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                        <button type="submit">
                            Добавить
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection