<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Mail\PasswordResetOtpMail;
use App\Http\Controllers\SizeGuideController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOptionController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user', [AuthController::class, 'updateProfile']);
    Route::post('/verify-password', [AuthController::class, 'verifyPassword']);
    Route::put('/change-password', [AuthController::class, 'updatePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
});



// public 
Route::get('/size-guides', [SizeGuideController::class, 'index']);
Route::get('/collections', [CollectionController::class, 'index']);
Route::get('/brands', [BrandController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);


Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    // size-guides
    Route::get('/size-guides/search', [SizeGuideController::class, 'search']);
    Route::post('/size-guides', [SizeGuideController::class, 'store']);
    Route::put('/size-guides/{sizeGuide}', [SizeGuideController::class, 'update']);
    Route::delete('/size-guides/{sizeGuide}', [SizeGuideController::class, 'destroy']);


    // collections 
    Route::get('/collections', [CollectionController::class, 'adminIndex']);
    Route::post('/collections', [ CollectionController::class, 'store']);
    Route::put('/collections/{collection}', [CollectionController::class, 'update']);
    Route::delete('/collections/{collection}', [CollectionController::class, 'destroy']);


    // Brands
    Route::get('/brands', [BrandController::class, 'adminIndex']);
    Route::post('/brands', [BrandController::class, 'store']);
    Route::put('/brands/{brand}', [BrandController::class, 'update']);
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy']);


    // Categories
    Route::get('/categories', [CategoryController::class, 'adminIndex']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);


    // Products
    Route::get('/products', [ProductController::class, 'adminIndex']);
    Route::get('/products/search', [ProductController::class, 'search']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);



    // Products form dropdown data
    Route::get('/brands', [ProductOptionController::class, 'brands']);
    Route::get('/categories', [ProductOptionController::class, 'categories']);
    Route::get('/collections', [ProductOptionController::class, 'collections']);
    Route::get('/sizes', [ProductOptionController::class, 'sizes']);

});





// GET     /api/products
// GET     /api/products/{slug}

// GET     /api/admin/products
// GET     /api/admin/products/search?search=frock
// POST    /api/admin/products
// PUT     /api/admin/products/{product}
// DELETE  /api/admin/products/{product}

// GET     /api/admin/product-options/brands
// GET     /api/admin/product-options/categories
// GET     /api/admin/product-options/collections
// GET     /api/admin/product-options/sizes


// Route::get('/test-email', function () {
//     Mail::to('ahmedmalik30600@gmail.com')->send(
//         new PasswordResetOtpMail('583214')
//     );

//     return response()->json([
//         'message' => 'Test email sent successfully.',
//     ]);
// });

