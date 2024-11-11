<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Partitura</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css'); }}">
</head>
<body>
    <div class="container mt-5">
        <h3>Processing {{ $partitura->nombre }}... Please wait.</h3>
        <div class="progress">
            <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js'); }}"></script>
    <script>
        var partituraId = {{ $partitura->id }};
        function updateProgress() {
            $.get('/progress/' + partituraId, function(data) {
                var progressBar = $('#progress-bar');
                progressBar.css('width', data + '%');
                progressBar.attr('aria-valuenow', data);
                progressBar.text(data + '%');

                if (data < 100) {
                    setTimeout(updateProgress, 2000); // Poll every 2 seconds
                } else {
                    alert('Processing complete!');
                    window.location.href = '/partitura'; // Redirect to the final page
                }
            });
        }

        updateProgress(); // Start polling
    </script>
</body>
</html>