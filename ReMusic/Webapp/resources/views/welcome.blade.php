<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<title>ReMusic</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<style>
			body {
				background-color: lightgray;
				background-position: center center;
				background-repeat: no-repeat;
				background-size: 150em;
			}
		</style>
	</head>
	<body>
		<div>
			<div class="p-2 m-2 bg-info text-white shadow rounded-2">
				<nav class="navbar navbar-expand-lg navbar-light bg-light">
					<a class="navbar-brand" href="/">ReMusic</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarNav">
						<ul class="navbar-nav">
						<li class="nav-item active">
							<a class="nav-link" href="/partituras/create">Subir Nueva</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link" href="/partituras">Galeria</a>
						</li>
						</ul>
					</div>
				</nav>
			</div>
		</div>

		<div class="container">
			@yield('main')
		</div>

	</body>
</html>
