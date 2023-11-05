<?php

use App\Http\Controllers\TermosPrivacidadeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\admin\NewsController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CompanieController;
use App\Http\Controllers\admin\VisitorController;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', [HomePageController::class, 'index'])->name('/');
Route::get('/terms_privacy', [TermosPrivacidadeController::class, 'index'])->name('/terms_privacy');
//rotas do login com o google
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('verificar_email/{email}', [App\Http\Controllers\UserController::class,"verifyEmail"])->name("verify_email");



Auth::routes();

Route::middleware(['auth'])->group(function () {
// Comentários
Route::post('/comentario', [CommentController::class,"store"])->name('comment.store');
Route::put("/comentario/{comment}", [CommentController::class,"update"])->name('comment.update');
Route::delete('/comentario/{comment}', [CommentController::class,"destroy"])->name('comment.destroy');
});

Route::middleware(['auth','can:admin-access'])->group(function () {
    Route::get('/dashboard', [NewsController::class, 'index'])->name('dashboard');
    Route::get('/categories', [SystemController::class, 'categories'])->name('categories');
    Route::get('/companies', [SystemController::class, 'companies'])->name('companies');
    Route::get('/visitors', [SystemController::class, 'visitors'])->name('visitors');
    Route::get('/profile', [SystemController::class, 'profile'])->name('profile');
    Route::get('/news/form', [NewsController::class,"create"])->name('news.create');
    Route::post('/post', [NewsController::class,"store"])->name('news.store');
    Route::get('/news/{news}', [NewsController::class,"edit"])->name('news.edit');
    Route::put("/news/{news}", [NewsController::class,"update"])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class,"destroy"])->name('news.destroy');
    Route::delete('/visitantes/{id}', [NewsController::class, 'destroy'])->name('visitantes.destroy');
    // Rota que desvincula a categoria
    Route::get('/category/desvincular/{category_news}/{dataNew}', [NewsController::class,"desvincular"])->name('category.desvincular');
    
    // Categorias
    Route::get('/categories/form', [CategoryController::class,"create"])->name('categories.create');
    Route::get('/categories/{categories}', [CategoryController::class,"edit"])->name('categories.edit');
    Route::post('/categories', [CategoryController::class,"store"])->name('categories.store');
    Route::put("/categories/{categories}", [CategoryController::class,"update"])->name('categories.update');
    Route::delete('/categories/{categories}', [CategoryController::class,"destroy"])->name('categories.destroy');

    //Empresas
    Route::put("/companies/{user}", [CompanieController::class,"switch"])->name('companies.switch');
    Route::delete('/companies/{user}', [CompanieController::class,"destroy"])->name('companies.destroy');

    //Visitantes
    Route::put("/visitors/{user}", [VisitorController::class,"switch"])->name('visitors.switch');
    Route::delete('/visitors/{user}', [VisitorController::class,"destroy"])->name('visitors.destroy');
});

Route::middleware(['auth', 'can:create,App\Models\News'])->group(function () {
    Route::get('/dashboard', [NewsController::class, 'index'])->name('dashboard');
    Route::get('/profile', [SystemController::class, 'profile'])->name('profile');
    Route::get('/news/form', [NewsController::class, "create"])->name('news.create');
    Route::post('/post', [NewsController::class, "store"])->name('news.store');
    Route::get('/news/{news}', [NewsController::class, "edit"])->name('news.edit');
    Route::put("/news/{news}", [NewsController::class, "update"])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, "destroy"])->name('news.destroy');
});


Route::get('/{news:slug}',[App\Http\Controllers\HomePageController::class,"get"])->name('news.open');

Route::get('/categoria/{category:name_category}',[App\Http\Controllers\HomePageController::class,"category"])->name('category.open');


