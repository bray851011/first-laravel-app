<?php

use App\Models\Post;
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

Route::get('/post/{post}', function ($slug) {

    $post = Post::find($slug);
  
    // Find a post by its slug and pass it to a view called "post"
    return view('post', [
        'post' => $post
    ]);

}) -> where('post','[A-z_\-]+'); // adding constraints to the path
// -> whereAlpha();
// -> whereNumber();


Route::get('/', function () {
    return view('welcome', [
        'posts' => Post::all()
    ]);
});
