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
    <div class="container-fluid">
        <div class="p-2 m-2 rounded-2" style="background-color: #6b8e23;">
            <form method="post" action="{{ route('partituras.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">    
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" name="nombre" required/>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Subir Imagen</label>
                    <input class="form-control" type="file" accept="image/*" capture="camera" id="imagen" name="imagen" required>
                </div>
                <button type="submit" class="btn btn-primary text-black">Subir y Digitalizar</button>
            </form>
        </div>
    </div>
</div>

@endsection