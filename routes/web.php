<?php

use Illuminate\Support\Facades\Route;

use function PHPUnit\Framework\fileExists;

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

    $path = __DIR__. "/../resources/posts/{$slug}.html";

    if(! fileExists($path)){
        dd($path);
        //ddd();
        //abort(404);
        //return redirect('/');
    }

    // caching 
    $post = cache() -> remember("post.{$slug}", now() -> addMinutes(5), fn() =>  file_get_contents($path));

    return view('post', [
        'post' => $post // extracted to post
    ]);
}) -> where('post','[A-z_\-]+'); // adding constraints to the path
// -> whereAlpha();
// -> whereNumber();




Route::get('/', function () {
    return view('welcome');
});
