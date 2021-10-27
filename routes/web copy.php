<?php

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;


Route::post('/upload', 'ToolController@upload')->name('upload');

Route::get('/', 'MainController@index');

Route::get('/test2/{post}', 'PostController@list_test');
Route::get('/test', 'TestController@index');


Auth::routes();
Route::get('/logout', 'Auth\\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'middleware' => ['auth']
], function() {
    Route::get('/profile', 'ProfileController@index');
    Route::post('/profile', 'ProfileController@update');
});

/// Admin Start 
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'isAdmin'],
    'namespace' => 'Admin'
], function() {
    Route::get('/', 'AdminController@index');
    Route::resource('/roles', 'RolesController');
    Route::resource('/permissions', 'PermissionsController');
    Route::resource('/users', 'UsersController');
    
    Route::resource('/pages', 'PagesController');
    Route::resource('/activitylogs', 'ActivityLogsController')->only([
        'index', 'show', 'destroy'
    ]);
    Route::resource('/settings', 'SettingsController');
    Route::resource('/banners', 'BannersController');
    Route::resource('/posts', 'PostsController');

    Route::resource('/tags', 'TagsController');
        

    Route::post('/banners/{id}/status', 'BannersController@status')->name('banners.status');
    Route::resource('/statics', 'StaticsController');

    // Route::resource('admin/tasks', 'Admin\\TasksController');
    Route::GET('/tools/status', 'ToolsController@status');
});

Route::group(['prefix' => 'admin',  'middleware' => [] ], function()
{
    // Route::get('generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
    // Route::post('generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);
});

// Route::group(['middleware'=>['auth', 'isAdmin' ] ,  ] , function(){
// Route::group(['middleware' => [], 'prefix'='admin'], function () {
// });
/// Admin END

/// User WWW Start

Route::resource('posts', 'PostController')->only([
    'index',  'store', 'show', 'create', 'update', 'destroy'
]);

// Route::resource('customers', 'CustomerController')->only([
//     'index',  'store', 'show', 'create', 'update', 'destroy'
// ]);

Route::resource('customers', 'CustController')->only([
    'index',  'store', 'show', 'create', 'update', 'destroy'
]);

Route::get('inputPassword', 'CustController@inputPassword')->name('inputPassword');


Route::get('tags/{tag}', 'TagController@index');

Route::get('click', 'ClickController@redirect');
Route::get('navigate', 'ClickController@navigate');

Route::resource('/upsos', 'UpsoController');
Route::resource('/managers', 'ManagerController');
Route::get('/managers-list', 'ManagerController@list')->name('managers.list');

Route::get('/managers-test/{manager}', 'ManagerController@test');

Route::post('/comments/save', 'CommentController@store')->name('comments.store');

/// User WWW END

View::composer('*', function ($view) {

    $user_menus = [
        ['key' => 'upsos', 'title' =>'업소정보', 'type'=>'upso' ,'link'=>'/upsos', 'src' => '/img/kr-111.jpg' ],
        ['key' => 'managers', 'title' =>'매니저정보', 'type'=>'manager' ,'link'=>'/managers', 'src' => '/img/kr-111.jpg' ],

        ['key' => 'kr', 'title' =>'한국야동', 'type'=>'gallery' ,'link'=>'/posts?cat_id=1', 'src' => '/img/kr-111.jpg' ],
        ['key' => 'jp', 'title' =>'일본야동', 'type'=>'gallery','link'=>'/posts?cat_id=2', 'src' => '/img/jp-111.jpg' ],
        ['key' => 'asia', 'title' =>'동양야동', 'type'=>'gallery','link'=>'/posts?cat_id=3', 'src' => '/img/dy-111.jpg' ],
        ['key' => 'western', 'title' =>'서양야동', 'type'=>'gallery','link'=>'/posts?cat_id=4', 'src' => '/img/xy-111.jpg' ],
        
        ['key' => 'torrent', 'title' =>'av토렌트', 'type'=>'torrent','link'=>'https://yaburi01.com/posts-index/19', 'src' => '/img/avtorrent.jpg' ],

        ['key' => 'bbs', 'title' =>'고객센터', 'type'=>'dropdown','link'=>'/customers?ccat_id=1', 'src' =>'' ],

        
        ['key' => 'upso', 'title' =>'업소정보', 'type'=>'outlink','link'=>'/', 'src' => '/img/upso.jpg' ],
        ['key' => 'broadcast', 'title' =>'스포츠중계', 'type'=>'outlink','link'=>'http://betmoa00.com', 'src' => '/img/betmoa.jpg' ],
        ['key' => 'bet', 'title' =>'놀이터', 'type'=>'outlink', 'link'=>'/' , 'src' => '/img/lets_play.jpg' ],
        ['key' => 'quest', 'title' =>'1:1문의', 'type'=>'list-password', 'link'=>'/customers?ccat_id=1', 'src' => '' ],
        ['key' => 'banner', 'title' =>'광고문의', 'type'=>'list-password', 'link'=>'/customers?ccat_id=2', 'src' => '' ],
    ];

    // $user_menus = json_decode(json_encode($user_menus), FALSE);
    // dd($user_menus);

    

    $banners = [];
    foreach( range(1,12) as $x ){
        $banners[] = ['file_name'=>'/storage/upload/banners/1.gif', 'link'=>'https://daum.net'];
    }
    $banners = json_decode(json_encode($banners), FALSE);
    $fb='banners.json';
    if ( !  Storage::exists( $fb) ){
        Banner::saveBanner();
    }

    $object = (array)json_decode( Storage::get($fb)  );
    $collection = Banner::hydrate($object);
    $banners = $collection->flatten();   // get rid of unique_id_XXX

    $view->with('user_menus', $user_menus )->with('banners', $banners);
});
 