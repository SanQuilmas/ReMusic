<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<title>ReMusic</title>
		<link href="{{ asset('css/bootstrap.min.css'); }}" rel="stylesheet">

		<script src="{{ asset('js/bootstrap.bundle.min.js'); }}"></script>

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
