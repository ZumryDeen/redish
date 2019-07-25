<?php

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

Use Illuminate\Support\Facades\Redis;
use App\Post;
Use Illuminate\Support\Facades\DB;

Route::get('/', function () {


  return view('welcome');
});

Route::get('/visit', function () {

    $visit = Redis::incr('visit');
    return $visit;
    return view('welcome');
});

Route::get('/rpost', function () {
    DB::enableQueryLog();
    if($posts = Redis::get('posts.all')) {

        $redispost = json_decode($posts);
        // print_r($redispost);

        $qry = DB::getQueryLog($redispost);
    }


        $posts = Post::take(1000)->get();

        Redis::set('posts.all', $posts);

    print_r($posts);
});


Route::get('/post', function () {


    DB::enableQueryLog();
    $posts = Post::take(100)->get();
$qry = DB::getQueryLog();
   // Redis::set('posts.all',$posts);

    // $post100 = Post::take(100)->get();
    //dd($post100);
    print_r($qry);

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
