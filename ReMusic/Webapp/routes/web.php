    <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartituraController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('partituras', PartituraController::class);
Route::get('/progress/{id}', [PartituraController::class, 'getProgress']);