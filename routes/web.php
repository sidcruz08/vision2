<?php
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;  // Correct import

// use App\Http\Controllers\PatientController;
// use App\Http\Controllers\VisitController;
// use App\Http\Controllers\DiagnosisController;
// use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\{PatientController, VisitController, DiagnosisController, TreatmentController, ClaimController, ClaimItemController, ClaimDocumentController};
use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::post('/claims', [ClaimController::class, 'processClaim']);
Route::get('/claims/create', [ClaimController::class, 'create'])->name('claims.create');
Route::post('/claims', [ClaimController::class, 'store'])->name('claims.store');

Route::get('/upload-pdf', [DocumentController::class, 'showForm']);
Route::post('/process-ocr', [DocumentController::class, 'process'])->name('ocr.process');

Route::resource('patients', PatientController::class);
Route::resource('visits', VisitController::class);
Route::resource('diagnoses', DiagnosisController::class);
Route::resource('treatments', TreatmentController::class);
// Route::resource('claims', ClaimController::class);
Route::resource('claim-items', ClaimItemController::class);
Route::post('claim-items/{claimItem}/documents', [ClaiocumentController::class, 'store'])->name('claim-items.documents.store');

Route::get('/', function () {
    return view('welcome');
});

// Route::resource('patients', PatientController::class);
// Route::post('/analyze-image', [ImageController::class, 'analyzeImage']); // POST (For uploading)
Route::get('/analyze-stored-image', [ImageController::class, 'validateDocument']); // GET (For testing stored image)

Route::get('/analyze-stored', [ImageController::class, 'processImage']); // GET (For testing stored image)

