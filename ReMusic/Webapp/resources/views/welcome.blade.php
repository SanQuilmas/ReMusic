<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<title>ReMusic</title>
		<link href="{{ asset('css/bootstrap.min.css'); }}" rel="stylesheet">

		<script src="{{ asset('js/bootstrap.bundle.min.js'); }}"></script>

		<style>
		body {
            background-color: #eaeaea; /* Fondo gris claro */
            background-size: cover;
            background-attachment: fixed;
            color: #000000; /* Texto en tono café oscuro */
            font-family: 'Lora', serif; /* Fuente elegante */
        }
        .navbar {
            background-color: #6b8e23; /* Verde oliva para la barra de navegación */
        }
        .navbar-brand, .nav-link {
            color: #ffffff !important; /* Texto blanco para contraste */
        }
        .header-section {
            background: linear-gradient(135deg, rgba(107, 142, 35, 0.9), rgba(234, 234, 234, 0.8)); /* Degradado transparente */
            color: #4e3629;
            padding: 5rem 0;
        }
        footer {
            background-color: #4e3629; /* Fondo café oscuro */
            color: #eaeaea; /* Texto en gris claro */
        }
        .btn-outline-dark {
            border-color: #6b8e23;
            color: #6b8e23;
        }
        .btn-outline-dark:hover {
            background-color: #6b8e23;
            color: #ffffff;
        }
		</style>
	</head>
	<body>
		<nav class="navbar navbar-expand-sm">
			<div class="container">
				<a class="navbar-brand" href="/">ReMusic</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
					<li class="nav-item active">
						<a class="nav-link" href="/partituras/create">New Upload</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="/partituras">Gallery</a>
					</li>
					</ul>
				</div>
			</div>
		</nav>

		<header class="header-section text-center">
			<div class="container">
				<h1 class="display-4">ReMusic</h1>
				<p class="lead">Scan physical sheet music and convert it into an editable digital format.</p>
			</div>
    	</header>

		<div class="container my-5">
			@yield('main')
		</div>

		<footer class="py-4 text-center">
			<p>&copy; 2024 ReMusic. All rights reserved.</p>
    	</footer>

	</body>
</html>
