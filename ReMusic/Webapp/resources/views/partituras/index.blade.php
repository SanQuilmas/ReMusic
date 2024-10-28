@extends('welcome')

@section('main')

<div class="container">
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Imagen</th>
                <th scope="col">Archivo</th>
                <th scope="col" colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($partituras as $partitura)
                <tr>
                    <td>{{ $partitura->id }}</td>
                    <td>{{ $partitura->nombre }}</td>

                    <td>
                        <img src="{{ Storage::url($partitura->image_path) }}" alt="{{ $partitura->nombre }}" style="max-width: 250px; height: auto;">
                    </td>

                    <td>
                        <div id="progress-container-{{ $partitura->id }}" style="display: none;">
                            <div class="progress">
                                <div id="progress-bar-{{ $partitura->id }}" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>

                        <div id="download-container-{{ $partitura->id }}">
                            <a href="{{ route('partituras.show', $partitura->id) }}" class="btn btn-success">
                                Ver y Descargar MusicXML
                            </a>
                        </div>
                    </td>

                    <td>
                        <form action="{{ route('partituras.destroy', $partitura->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
                
                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script>
                    console.log('Script Loaded'); // Check if the script is loaded
                    $(document).ready(function() {
                        (function(partituraId) {
                            console.log('Checking progress for ID:', partituraId); // Log the ID

                            function updateProgress() {
                                $.get('/progress/' + partituraId, function(data) {
                                    // If progress is null, undefined, or less than 100, and file exists, show the download button
                                    console.log(data);

                                    var progressBar = $('#progress-bar-' + partituraId);
                                    var progressContainer = $('#progress-container-' + partituraId);
                                    var downloadContainer = $('#download-container-' + partituraId);
                                    
                                    downloadContainer.hide();

                                    if (data === null || typeof data === 'undefined' || data >= 100 || data == 0) {
                                        console.log('Progress is null or complete, showing download button.');
                                        progressContainer.hide(); // Hide progress bar
                                        downloadContainer.show(); // Show download button
                                        return; // Exit the function early
                                    }

                                    // Update progress bar
                                    progressBar.css('width', data + '%');
                                    progressBar.attr('aria-valuenow', data);
                                    progressBar.text(data + '%');

                                    if (data < 100) {
                                        // Show progress bar and hide download button
                                        progressContainer.show();
                                        downloadContainer.hide();
                                        setTimeout(updateProgress, 20000); // Poll every 2 seconds
                                    } else {
                                        // Show download button and hide progress bar when completed
                                        alert('Processing complete!');
                                        progressContainer.hide();
                                        downloadContainer.show();
                                    }
                                }).fail(function(jqXHR, textStatus, errorThrown) {
                                    console.error('Error fetching progress:', textStatus, errorThrown); // Log any errors
                                    // If there's an error fetching progress, default to showing download button
                                    $('#progress-container-' + partituraId).hide();
                                    $('#download-container-' + partituraId).show();
                                });
                            }

                            updateProgress(); // Start polling
                            
                        })({{ $partitura->id }}); // Immediately invoke the function with the current partitura ID
                    });
                </script>
                
            @endforeach
        </tbody>
    </table>
</div>

@endsection