<?php

use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
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

Route::get('/controller/hello/request', [HelloController::class, 'request']);
Route::get('/controller/hello/{name}', [HelloController::class, 'hello']);

Route::get('input/hello', [InputController::class,'hello']);
Route::post('input/hello', [InputController::class,'hello']);
Route::post('input/hello/first', [InputController::class,'helloFirstName']);
Route::post('input/hello/input', [InputController::class,'helloInput']);
Route::post('input/hello/array', [InputController::class,'helloArray']);
