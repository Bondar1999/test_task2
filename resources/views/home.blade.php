@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ $message }}
                    <p>
                        <form action="/show" method="GET">
                            <select name="tableName">
                                <option value="food">Food</option>
                                <option value="products">Products</option>
                                <option value="food_products">Food_products</option>
                                <option value="worker">Worker</option>
                            </select>
                            <button type="submit">
                                Показать
                            </button>
                        </form>
                    </p>
                    <p>
                        <a href="/task1">Информация о приготовленных блюдах за заданный период с расчетом их прибыльности</a>
                    </p>
                    <p>
                        <a href="/task2">Информация по расчету оплаты сотрудникам за выбранный период</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
