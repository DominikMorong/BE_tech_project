<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConferenceRegistrationController;
use App\Http\Controllers\CustomPageController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\TalkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// This shit is retarded you must use Accept : application/json http header

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/self', [AuthController::class, 'getSelf'])->middleware('auth:sanctum');

// ->middleware('auth:sanctum') checks if user is authenticated
Route::post('/sponsor', [SponsorController::class, 'addSponsor'])->middleware('auth:sanctum');
Route::delete('/sponsor/{id}', [SponsorController::class, 'deleteSponsor'])->middleware('auth:sanctum');
Route::put('/sponsor/{id}', [SponsorController::class, 'updateSponsor'])->middleware('auth:sanctum');
Route::get('/sponsor', [SponsorController::class, 'getSponsors']);

Route::get('/speaker', [SpeakerController::class, 'getSpeakers']);
Route::post('/speaker', [SpeakerController::class, 'addSpeakder'])->middleware('auth:sanctum');
Route::delete('/speaker/{id}', [SpeakerController::class, 'deleteSpeaker'])->middleware('auth:sanctum');
Route::put('/speaker/{id}', [SpeakerController::class, 'updateSpeaker'])->middleware('auth:sanctum');

Route::post('/upload', [ImageController::class, 'saveImage'])->middleware('auth:sanctum');

Route::get('/custom', [CustomPageController::class, 'getCustomPages']);
Route::get('/custom/{name}', [CustomPageController::class, 'getCustomPage']);
Route::post('/custom', [CustomPageController::class, 'createCustomPage'])->middleware('auth:sanctum');
Route::put('/custom/{id}', [CustomPageController::class, 'updatePage'])->middleware('auth:sanctum');
Route::delete('/custom/{id}', [CustomPageController::class, 'deletePage'])->middleware('auth:sanctum');

Route::get('/stage', [StageController::class, 'getStages']);
Route::post('/stage', [StageController::class, 'createStage'])->middleware('auth:sanctum');
Route::post('/stage/{stage}/timePeriods', [StageController::class, 'addTimePeriod'])->middleware('auth:sanctum');
Route::delete('/stage/{id}', [StageController::class, 'deleteStage'])->middleware('auth:sanctum');
Route::delete('/stage/{stageId}/{timePeriodId}', [StageController::class, 'deleteTimePeriod'])->middleware('auth:sanctum');
Route::put('/stage/{id}', [StageController::class, 'updateStage'])->middleware('auth:sanctum')->middleware('auth:sanctum');
Route::put('/stage/timePeriod/{id}', [StageController::class, 'updateTimePeriod'])->middleware('auth:sanctum');

Route::get('/talk', [TalkController::class, 'getTalks']);
Route::post('/talk', [TalkController::class, 'createTalk'])->middleware('auth:sanctum');
Route::delete('/talk/{id}', [TalkController::class, 'deleteTalk'])->middleware('auth:sanctum');
Route::put('/talk/{id}', [TalkController::class, 'updateTalk'])->middleware('auth:sanctum');
Route::get('/talk/{id}', [TalkController::class, 'getTalk']);


Route::get('/review', [ReviewController::class, 'getReviews']);
Route::get('/review{id}', [ReviewController::class, 'getReview']);
Route::post('/review', [ReviewController::class, 'createReview'])->middleware('auth:sanctum');
Route::delete('/review/{id}', [ReviewController::class, 'deleteReview'])->middleware('auth:sanctum');
Route::put('/review/{id}', [ReviewController::class, 'updateReview'])->middleware('auth:sanctum');


Route::post('/galleryCategory', [GalleryController::class, 'createGalleryCategory'])->middleware('auth:sanctum');
Route::post('/gallery', [GalleryController::class, 'createGallery'])->middleware('auth:sanctum');
Route::get('/galleryCategory', [GalleryController::class, 'getCategories']);
Route::get('/gallery/{id}', [GalleryController::class, 'getGalleryByGalleryCategoryId']);

Route::post('/registration', [ConferenceRegistrationController::class, 'createRegistration']);
Route::delete('/registration/{token}', [ConferenceRegistrationController::class, 'cancelRegistration']);
Route::get('/registration', [ConferenceRegistrationController::class, 'getRegistrations'])->middleware('auth:sanctum');
