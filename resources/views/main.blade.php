<!DOCTYPE html>
<html>
<head>
	<title>DATA BASE</title>
</head>
<body>
	<div>
		<?php 
			//{{ url('/user') }}
		?>
		<form action="/login" method="POST">
			{{ csrf_field() }}
			<button type="submit">
				Вход
			</button>
		</form>
		<form action="/register" method="POST">
			{{ csrf_field() }}
			<button type="submit">
				Регистрация
			</button>
		</form>
		<a href="http://task2/login">Вход</a>
		<a href="http://task2/register">Регистрация</a>
	</div>
</body>
</html>