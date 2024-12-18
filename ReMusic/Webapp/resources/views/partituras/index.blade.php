@extends('welcome')

@section('main')

<div class="p-2 m-2 rounded-2">
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">File</th>
                <th scope="col" colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($partituras as $partitura)
                <tr>
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
                                Download and Show MusicXML
                            </a>
                        </div>
                    </td>

                    <td>
                        <form action="{{ route('partituras.destroy', $partitura->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit" style="background-color: #D10000;">Delete</button>
                        </form>
                    </td>
                </tr>
                
                <script src="{{ asset('js/jquery.min.js'); }}"></script>
                <script>
                    window.onload = function() { 
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
                                        
                                        if (data === null || typeof data === 'undefined' || data >= 100 || data == 0) {
                                            console.log('Progress is null or complete, showing download button.');
                                            progressContainer.hide(); // Hide progress bar
                                            downloadContainer.show(); // Show download button
                                            return; // Exit the function early
                                        }
                                        
                                        var truncatedData = parseFloat(data).toFixed(2);

                                        // Update progress bar
                                        progressBar.css('width', truncatedData + '%');
                                        progressBar.attr('aria-valuenow', truncatedData);
                                        progressBar.text(truncatedData + '%');

                                        if (data < 100) {
                                            // Show progress bar and hide download button
                                            progressContainer.show();
                                            downloadContainer.hide();
                                            setTimeout(updateProgress, 5000); // Poll every 2 seconds
                                        } else {
                                            // Show download button and hide progress bar when completed
                                            alert('Processing complete!');
                                            progressContainer.hide();
                                            downloadContainer.show();
                                        }
                                    });
                                }

                                updateProgress(); // Start polling
                                
                            })({{ $partitura->id }}); // Immediately invoke the function with the current partitura ID
                        });
                    }
                </script>
                
            @endforeach
        </tbody>
    </table>
</div>

@endsection