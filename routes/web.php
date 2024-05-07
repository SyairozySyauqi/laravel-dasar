<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Http\Middleware\ContohMiddleWare;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return "Test";
});

Route::redirect('/youtube', '/test');

Route::fallback(function () {
    return "404";
});

Route::view('/hello', 'hello', ['name' => 'M']);

Route::get('/helloo', function () {
    return view('hello', ['name' => 'M']);
});

Route::get('/helloWorld', function () {
    return view('hello.world');
});

Route::get('/products/{id}', function ($productId) {
    return "Product $productId";
})->name('product.detail');

Route::get('/products/{product}/items/{item}', function ($productId, $itemId) {       
    return "Product $productId, Item $itemId";
})->name('product.item.detail');

Route::get("/categories/{id}", function ($categoryId) {
    return "Category $categoryId";
})->where('id', '[0-9]+')->name('category.detail');

Route::get('/users/{id?}', function ($userId = '404') {
    return "User $userId";
})->name('user.detail');

Route::get("/conflict/m", function () {
    return "Conflict M S S";
});

Route::get("/conflict/{name}", function ($name) {
    return "Conflict $name";
});

Route::get("/produk/{id}", function ($id) {
    $link = route('product.detail', ['id' => $id]);
    return "Link $link";
});

Route::get("/produk-redirect/{id}", function ($id) {
    return redirect()->route('product.detail', ['id' => $id]);
});

Route::controller(HelloController::class)->group(function () {
    Route::get('/controller/hello/request', 'request');
    Route::get('/controller/hello/{name}', 'hello');
});

Route::get('/input/hello', [InputController::class,'hello']);
Route::post('/input/hello', [InputController::class,'hello']);
Route::post('/input/hello/first', [InputController::class,'helloFirstName']);
Route::post('/input/hello/input', [InputController::class,'helloInput']);
Route::post('/input/hello/array', [InputController::class,'helloArray']);

Route::post('/input/type', [InputController::class, 'inputType']);

Route::post('/input/filter/only', [InputController::class,'filterOnly']);
Route::post('/input/filter/except', [InputController::class,'filterExcept']);
Route::post('/input/filter/merge', [InputController::class,'filterMerge']);

Route::post('/file/upload', [FileController::class,'upload'])
    ->withoutMiddleware(VerifyCsrfToken::class);

Route::get('/response/hello', [ResponseController::class, 'response']);
Route::get('/response/header', [ResponseController::class, 'header']);
Route::prefix("/response/type")->group(function (){
    Route::get('/view', [ResponseController::class, 'responseView']);
    Route::get('/json', [ResponseController::class, 'responseJson']);
    Route::get('/file', [ResponseController::class, 'responseFile']);
    Route::get('/download', [ResponseController::class, 'responseDownload']);
});

Route::controller(\App\Http\Controllers\CookieController::class)->group(function (){
    Route::get('/cookie/set', 'createCookie');
    Route::get('/cookie/get', 'getCookie');
    Route::get('/cookie/clear', 'clearCookie');
});

Route::get('/redirect/from', [RedirectController::class, 'redirectFrom']);
Route::get('/redirect/to', [RedirectController::class, 'redirectTo']);
Route::get('/redirect/name', [RedirectController::class, 'redirectName']);
Route::get('/redirect/name/{name}', [RedirectController::class, 'redirectHello'])
    ->name('redirect-hello');
Route::get('/redirect/named', function (){
//    return route('redirect-hello', ['name' => 'MSS']);
//    return url()->route('redirect-hello', ['name' => 'MSS']);
    return URL::route('redirect-hello', ['name' => 'MSS']);
});
Route::get('/redirect/action', [RedirectController::class, 'redirectAction']);
Route::get('/redirect/away', [RedirectController::class, 'redirectAway']);

Route::middleware('contoh:PZN,401')->prefix('/middleware')->group(function (){
    Route::get('/api', function() {
        return "OK";
    });
    Route::get('/group', function() {
        return "Group";
    });    
});

Route::get('/url/action', function (){
    // return action([FormController::class, 'form'], []);
    // return url()->action([FormController::class, 'form'], []);
    return URL::action([FormController::class, 'form'], []);
});
Route::get('/form', [FormController::class,'form']);
Route::post('/form', [FormController::class,'submitForm']);

Route::get('/url/current', function () {
    return URL::full();
});