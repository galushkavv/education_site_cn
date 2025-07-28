<?php

use App\Http\Controllers\StaticContentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\ImageUploadController;

Route::get('/', function () {
    $language = app()->getLocale();
    return view('welcome_'.$language);
});

Route::get('about',      [StaticContentController::class, 'show'])->name('about')     ->defaults('slug', 'about');
Route::get('contacts',   [StaticContentController::class, 'show'])->name('contacts')  ->defaults('slug', 'contacts');
Route::get('enrollment', [StaticContentController::class, 'show'])->name('enrollment')->defaults('slug', 'enrollment');

// Смена языка | Change language
Route::get('change-language/{locale}', function ($locale)
    {
        if (in_array($locale, ['en', 'cn']))
            session(['locale' => $locale]);
        return redirect()->back();
});

// Преподаватели | Teachers
Route::middleware(['auth'])->group(function () {
    Route::resource('teachers', TeacherController::class)->except(['show']);
});


// Университеты | Universities
Route::get('study/{country}', [UniversityController::class, 'indexByCountry'])->name('universities.byCountry'); // маршрут для отображения университетов в конкретной стране

Route::middleware('auth')->group(function () {
    Route::resource('universities', UniversityController::class)->except(['index', 'show']);

    Route::patch('/universities/{university}/hide', [UniversityController::class, 'hide'])->name('universities.hide');
    Route::patch('/universities/{university}/show', [UniversityController::class, 'unhide'])->name('universities.unhide');
});

Route::resource('universities', UniversityController::class)->only(['index', 'show']);


// Образовательные программы | Majors
Route::middleware('auth')->group(function () {
    Route::resource('majors', MajorController::class)->except(['index', 'show']);
    Route::patch('/majors/{major}/hide', [MajorController::class, 'hide'])->name('majors.hide');
    Route::patch('/majors/{major}/unhide', [MajorController::class, 'unhide'])->name('majors.unhide');
});

// Публичные маршруты для просмотра образовательных программ
Route::resource('majors', MajorController::class)->only(['index', 'show']);


// Аутентификация | Authentication
Route::get ('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//////////////////////////////////
Route::post('/upload-image', [ImageUploadController::class, 'store'])->name('upload.image')->middleware('auth');
Route::post('/upload-teacher-photo', [ImageUploadController::class, 'storeTeacherPhoto'])->name('teacher.photo.upload');

