<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\fileExists;


class Post
{
    public static function find($slug)
    {
               // There are other path commands
               //vvvvvvvvvvvvv
        $path =  resource_path("posts/{$slug}.html");

        if(! fileExists($path)){
            throw new ModelNotFoundException();
            // dd($path);
            //ddd();
            // abort(404);
            //return redirect('/');
        }

        // caching 
        return  cache() -> remember("post.{$slug}", now() -> addMinutes(5), fn() =>  file_get_contents($path));
    }

    public static function all()
    {
        $files = File::files(resource_path("posts/"));

        return array_map( function($file){
            return $file -> getContents();
        }, $files);
    }
}