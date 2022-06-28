<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\Blog\PostsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('blog/posts/{post}', [PostsController::class,'show'])->name('blog.show');
Route::get('blog/categories/{category}', [PostsController::class,'category'])->name('blog.category');
Route::get('blog/tags/{tag}', [PostsController::class,'tag'])->name('blog.tag');

Auth::routes();


Route::middleware(['auth'])->group(function(){
    // so insteand of ahref /home /home and change all
    // u can just change/home here 
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('categories','CategoriesController');
    Route::resource('posts','PostController');
    Route::resource('tags','TagsController');
    Route::get('trashed-posts','PostController@trashed')->name('trashed-posts.index');
    Route::put('restore-posts/{post}','PostController@restore')->name('restore-posts');
    
});

Route::middleware(['auth','admin'])->group(function() {
    Route::get('users','UserController@index')->name('users.index');
    Route::get('users/profile','UserController@edit')->name('users.edit-profile');
    Route::post('users/{user}/make-admin','UserController@makeAdmin')->name('users.make-admin');
    Route::put('users/profile','UserController@update')->name('users.update-profile');
});

