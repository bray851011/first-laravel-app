<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

use function PHPUnit\Framework\fileExists;


class Post
{

    public $title;
    public $date;
    public $excerpt;
    public $body;
    public $slug;
    public function __construct($title, $date, $excerpt, $body, $slug)
    {
        $this->title = $title;
        $this->date = $date;
        $this->excerpt = $excerpt;
        $this->body = $body;
        $this->slug = $slug;
    }

    public static function find($slug)
    {
         
        return static::all()->firstWhere('slug', $slug);


        //        // There are other path commands
        //        //vvvvvvvvvvvvv
        // $path =  resource_path("posts/{$slug}.html");

        // if(! fileExists($path)){
        //     throw new ModelNotFoundException();
        //     // dd($path);
        //     //ddd();
        //     // abort(404);
        //     //return redirect('/');
        // }

        // // caching 
        // return  cache() -> remember("post.{$slug}", now() -> addMinutes(5), fn() =>  file_get_contents($path));
    }

    public static function all()
    {
        return collect(File::files(resource_path("posts/")))
                ->map(function($file){
                    return YamlFrontMatter::parseFile($file);
                })
                ->map(function($document){
                    return new Post(
                        $document->title,
                        $document->excerpt,
                        $document->date,
                        $document->body(),
                        $document->slug
                    );
                })
                ->sortByDesc('date');
        
        // // run cache()->forget('post.all') clear it from cache
        // return cache()->rememberForever('post.all', function(){
        //     return collect(File::files(resource_path("posts/")))
        //         ->map(function($file){
        //             return YamlFrontMatter::parseFile($file);
        //         })
        //         ->map(function($document){
        //             return new Post(
        //                 $document->title,
        //                 $document->excerpt,
        //                 $document->date,
        //                 $document->body(),
        //                 $document->slug
        //             );
        //         })
        //         ->sortByDesc('date');
        // });
        
            // ^^^^^^^^^^^^
            // they both are identical
            // vvvvvvvvvvvv
            // $posts = array_map(function($file){
            //     $document = YamlFrontMatter::parseFile($file);

            //     return new Post(
            //         $document->title,
            //         $document->excerpt,
            //         $document->date,
            //         $document->body(),
            //         $document->slug
            //     );
            // }, $files);
    }

    public static function findOrFail($slug)
    {
        $post = static::find($slug);
        if(! $post)
        {
            throw new ModelNotFoundException();
        }
        return $post;
    }
}