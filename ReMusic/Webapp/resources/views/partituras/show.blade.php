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
        <link rel="stylesheet" href="{{ asset('dist/musicxml-player.esm.css')}}">
        <script type="module" src="{{ asset('demo.mjs') }}"></script>
    <div>
      <label for="samples">Choose a sample from the list here</label>&nbsp;
      <select id="samples">
        <option value="">-- Choose --</option>
        <option value="data/salma-ya-salama.mxl">Salma ya Salama (Compressed MusicXML)</option>
        <option value="data/asa-branca.musicxml">Asa Branca (Uncompressed MusicXML)</option>
        <option value="data/tutorial-apres-un-reve.musicxml">Après un rêve (MuseScore Rendering)</option>
        <option value="data/rast-tetrachord.musicxml">Rast Tetrachords (Microtonal MusicXML)</option>
        <option value="data/baiao-miranda.musicxml">Baião Groove (Rhythm MusicXML)</option>
        <option value="data/jazz1460.txt">Playlist: Jazz 1460 (iReal Pro)</option>
      </select>
    </div>

    <div>
      <label for="upload">Or upload a MusicXML file or an iReal Pro playlist</label>&nbsp;
      <input type="file" id="upload" name="upload"/>
      <span id="error"></span>
    </div>

    <div>
      <label for="ireal">Or paste an iReal Pro song URI directly</label>&nbsp;
      <input type="text" size="50" id="ireal" name="ireal" placeholder="irealb://... or irealbook://..."/>
    </div>

    <div>
      Sheets
      <select id="sheets"></select>
      <span id="download-musicxml"></span>
      <span id="download-midi"></span>
    </div>

    <div>
      Renderer
      <input type="radio" id="renderer-osmd" name="renderer" value="osmd"/>
      <label for="renderer-osmd">OpenSheetMusicDisplay</label>
      <input type="radio" id="renderer-vrv" name="renderer" value="vrv"/>
      <label for="renderer-vrv">Verovio</label>
      <input type="radio" id="renderer-mscore" name="renderer" value="mscore"/>
      <label for="renderer-mscore">MuseScore (SVG)</label>
      <div class="renderer-options">
        <input type="checkbox" class="renderer-option" id="option-unroll" value="unroll"/>
        <label for="option-unroll">Unroll score</label>
        <input type="checkbox" class="renderer-option" id="option-horizontal" value="horizontal"/>
        <label for="option-horizontal">Horizontal layout</label>
      </div>
    </div>

    <div>
      Converter
      <input type="radio" id="converter-midi" name="converter" value="midi"/>
      <label for="converter-midi">Custom MIDI</label>
      <input type="radio" id="converter-mma" name="converter" value="mma"/>
      <label for="converter-mma">MusicXML MMA</label>
      <input type="radio" id="converter-vrv" name="converter" value="vrv"/>
      <label for="converter-vrv">Verovio</label>
      <input type="radio" id="converter-mscore" name="converter" value="mscore"/>
      <label for="converter-mscore">MuseScore</label>
    </div>

    <div>
      <label for="grooves">Groove</label>
      <input list="grooves-list" id="grooves"/>
      <datalist id="grooves-list"></datalist>
      Depends on the MusicXML MMA converter.
    </div>

    <div>
      <label for="outputs">MIDI output</label>
      <select id="outputs"></select>
      <input type="checkbox" class="player-option" id="option-mute" value="mute"/>
      <label for="option-mute">Mute</label>
      <div>
        If you're not using the local synth, you need to connect this output to a MIDI synth like FluidSynth, TiMidity, or <a href="https://mmontag.github.io/dx7-synth-js/" target="_blank">DX7 Synth</a>.
      </div>
    </div>

    <div>
      <label for="audio-file">Audio track and offset</label>
      <input type="file" id="audio-file" name="upload"/>
      <input type="number" id="audio-offset" name="audio-offset" value="0" step="50" disabled/> ms.
      <div>
        <audio id="audio-track"></audio>
      </div>
    </div>

    <div>
      <label for="velocity">Velocity</label>
      <input type="number" id="velocity" name="velocity" value="1" min="0.25" max="2" step="0.25"/>
      <label for="repeat">Repeat</label>
      <select id="repeat" name="repeat">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="-1">∞</option>
      </select>
    </div>

    <div id="player">
      <button class="player" id="rewind">⏮</button>
      <button class="player" id="pause">⏸</button>
      <button class="player" id="play">▶</button>
    </div>

    <div id="sheet-container"></div>

    </div>

@endsection