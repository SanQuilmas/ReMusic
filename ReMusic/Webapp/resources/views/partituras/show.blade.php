@extends('welcome')

@section('main')

<div class="row">
	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div><br />
	@endif

	<div class="p-2 m-2 bg-info text-black shadow rounded-2">
		<div>
		<h1>Nombre: {{ $partitura->nombre }}</h1>
            <plabel>Archivo MusicXML:</label>
            <a href="{{ Storage::url($partitura->musicxml_path) }}" class="btn btn-primary" download>Descargar MusicXML</a>
		</div>
		<div id="osmdContainer"/>
		<script src="{{ asset('opensheetmusicdisplay.min.js') }}"></script>
		<script>
			var osmd = new opensheetmusicdisplay.OpenSheetMusicDisplay("osmdContainer");
			osmd.setOptions({
				backend: "svg",
				drawTitle: true,
				drawingParameters: "compacttight" // don't display title, composer etc., smaller margins
			});
			osmd
				.load("{{ Storage::url($partitura->musicxml_path) }}")
				.then(
				function() {
					osmd.render();
				}
			);
		</script>
	</div>

@endsection