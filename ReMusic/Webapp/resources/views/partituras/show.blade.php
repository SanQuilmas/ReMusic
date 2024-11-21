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

	<div class="container">
		<div class="p-2 m-2 rounded-2" style="background-color: #6b8e23;">
			<div>
			<h1>{{ $partitura->nombre }}</h1>
				<plabel>Archivo MusicXML:</label>
				<a href="{{ Storage::url($partitura->musicxml_path) }}" class="btn btn-primary text-black" download style="background-color: #228CDB;">Descargar MusicXML</a>

				<plabel>Archivo Midi:</label>
				<a href="{{ Storage::url($partitura->midi_path) }}" class="btn btn-primary text-black" download style="background-color: #228CDB;">Descargar Midi</a>
			</div>

			<div id="osmdContainer"/>
			<script src="{{ asset('opensheetmusicdisplay.min.js') }}"></script>
			<script>
				var osmd = new opensheetmusicdisplay.OpenSheetMusicDisplay("osmdContainer");
				osmd.setOptions({
					backend: "svg",
					drawTitle: true,
					drawingParameters: "compacttight" 
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

		<div class="p-2 m-2 rounded-2" style="background-color: #6b8e23;">
			<script src="{{ asset('html-midi-player.min.js') }}"></script>

			<midi-player
				src="{{ Storage::url($partitura->midi_path) }}"
				sound-font visualizer="#myVisualizer">
			</midi-player>
			<midi-visualizer type="piano-roll" id="myVisualizer"></midi-visualizer>
		</div>
	</div>
@endsection