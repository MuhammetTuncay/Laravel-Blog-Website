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

/*
|
|   BACKEND ROUTES
|
*/


/* Offline Site */

Route::get('aktif-degil', function (){
    return view('front.offline');
});




Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function (){
    Route::get('giris','Back\AuthController@login')->name('login');
    Route::post('giris','Back\AuthController@loginPost')->name('login.post');
});


Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function (){
    Route::get('panel','Back\Dashboard@index')->name('dashboard');
    // Makale Route
    Route::get('makaleler/silinenler', 'Back\ArticleController@trashed')->name('trashed.article');
    Route::resource('makaleler', 'Back\ArticleController');
    Route::get('/switch', 'Back\ArticleController@switch')->name('switch');
    Route::get('/deletearticle/{id}', 'Back\ArticleController@delete')->name('delete.article');
    Route::get('/harddeletearticle/{id}', 'Back\ArticleController@hardDelete')->name('hard.delete.article');
    Route::get('/recoverarticle/{id}', 'Back\ArticleController@recover')->name('recover.article');
    // Category Route
    Route::get('/kategoriler', 'Back\CategoryController@index')->name('category.index');
    Route::post('/kategoriler/create', 'Back\CategoryController@create')->name('category.create');
    Route::post('/kategoriler/update', 'Back\CategoryController@update')->name('category.update');
    Route::post('/kategoriler/delete', 'Back\CategoryController@delete')->name('category.delete');
    Route::get('/kategori/status', 'Back\CategoryController@switch')->name('category.switch');
    Route::get('/kategori/getData', 'Back\CategoryController@getData')->name('category.getdata');
    // Page Route
    Route::get('/sayfalar', 'Back\PageController@index')->name('page.index');
    Route::get('/sayfalar/olustur', 'Back\PageController@create')->name('page.create');
    Route::get('/sayfalar/guncelle/{id}', 'Back\PageController@update')->name('page.edit');
    Route::post('/sayfalar/guncelle/{id}', 'Back\PageController@updatePost')->name('page.edit.post');
    Route::post('/sayfalar/olustur', 'Back\PageController@createPost')->name('page.create.post');
    Route::get('/sayfa/switch', 'Back\PageController@switch')->name('page.switch');
    Route::get('/sayfa/sil/{id}', 'Back\PageController@delete')->name('page.delete');
    Route::get('/sayfa/siralama', 'Back\PageController@orders')->name('page.orders');
    // Ayarlar Config Route
    Route::get('/ayarlar', 'Back\ConfigController@index')->name('config.index');
    Route::post('/ayarlar/update', 'Back\ConfigController@update')->name('config.update');
    // Çıkış
    Route::get('cikis','Back\AuthController@logout')->name('logout');
});


/*
|
|   FRONTEND ROUTES
|
*/

Route::get('/', 'Front\HomepageController@index')->name('homepage');
Route::get('sayfa', 'Front\HomepageController@index');
Route::get('/iletisim', 'Front\HomepageController@contact')->name('contact');
Route::post('/iletisim', 'Front\HomepageController@contactpost')->name('contact.post');

//Route::post('/iletisim', 'Front\HomepageController@contactpost')->name('contact.post');


Route::get('/category/{category?}', 'Front\HomepageController@category')->name('category');
Route::post('/category/{category?}', 'Front\HomepageController@category')->name('category');
Route::get('/blog/{category}/{slug?}', 'Front\HomepageController@single')->name('single');
Route::post('/blog/{category}/{slug?}', 'Front\HomepageController@single')->name('single');
Route::get('/{page?}', 'Front\HomepageController@page')->name('page');
Route::post('/{page?}', 'Front\HomepageController@page')->name('page');


