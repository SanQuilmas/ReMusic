<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<title>ReMusic</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

		<style>
			body {
				background-color: #212529;
			}
		</style>
	</head>
	<body>
		<div class="container-fluid" style="height: 100px;">
			<div class="p-2 m-2 rounded-2" style="background-color: #885A5A;">
				<nav class="navbar navbar-expand-sm" style="background-color: #885A5A;">
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
		<div class="container-fluid" style="height: 100%;">
			@yield('main')
		</div>

	</body>
</html>
