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
use App\Http\Controllers\RatingController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HeroSlideController;
use App\Http\Controllers\PromoBannerController;
use App\Http\Controllers\StatItemController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\ContactInfoController;




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
Route::get('/collections/{slug}', [CollectionController::class, 'showBySlug']);
Route::get('/brands', [BrandController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'showBySlug']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/products/{slug}/related', [ProductController::class, 'related']);
Route::get('/products/{slug}/ratings', [RatingController::class, 'index']);
Route::post('/newsletters', [NewsletterController::class, 'store']);
Route::post('/contacts', [ContactController::class, 'store']);



Route::get('/hero-slides', [HeroSlideController::class, 'index']);
Route::get('/promo-banners', [PromoBannerController::class, 'index']);
Route::get('/stat-items', [StatItemController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);
Route::get('/faq', [FaqController::class, 'index']);
Route::get('/announcements', [AnnouncementController::class, 'index']);
Route::get('/instagram', [InstagramController::class, 'index']);
Route::get('/contact-info', [ContactInfoController::class, 'index']);




// auth required — create/update review
Route::middleware('auth:sanctum')->group(function () {
    // ... existing routes
    Route::post('/products/{slug}/ratings', [RatingController::class, 'store']);
});



Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    // size-guides
    Route::get('/size-guides/search', [SizeGuideController::class, 'search']);
    Route::post('/size-guides', [SizeGuideController::class, 'store']);
    Route::put('/size-guides/{sizeGuide}', [SizeGuideController::class, 'update']);
    Route::delete('/size-guides/{sizeGuide}', [SizeGuideController::class, 'destroy']);


    // collections 
    Route::get('/collections', [CollectionController::class, 'adminIndex']);
    Route::post('/collections', [ CollectionController::class, 'store']);
    Route::get('/collections/{collection}', [CollectionController::class, 'show']);
    Route::put('/collections/{collection}', [CollectionController::class, 'update']);
    Route::delete('/collections/{collection}', [CollectionController::class, 'destroy']);


    // Brands
    Route::get('/brands', [BrandController::class, 'adminIndex']);
    Route::get('/brands/search', [BrandController::class, 'search']);
    Route::post('/brands', [BrandController::class, 'store']);
    Route::get('/brands/{brand}', [BrandController::class, 'show']);
    Route::put('/brands/{brand}', [BrandController::class, 'update']);
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy']);


    // Categories
    Route::get('/categories', [CategoryController::class, 'adminIndex']);
    Route::get('/categories/search', [CategoryController::class, 'search']);  
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);


    // Products
    Route::get('/products', [ProductController::class, 'adminIndex']);
    Route::get('/products/search', [ProductController::class, 'search']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}', [ProductController::class, 'adminShow']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);


    // Products form dropdown data
    Route::prefix('product-options')->group(function () {

        Route::get('/brands', [ProductOptionController::class, 'brands']);
        Route::get('/categories', [ProductOptionController::class, 'categories']);
        Route::get('/collections', [ProductOptionController::class, 'collections']);
        Route::get('/sizes', [ProductOptionController::class, 'sizes']);

    });


    
    // Newsletters
    Route::get('/newsletters', [NewsletterController::class, 'index']);
    Route::delete('/newsletters/{newsletter}', [NewsletterController::class, 'destroy']);

    // Contact
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy']);


    // Contact Info
    Route::get('/contact-info', [ContactInfoController::class, 'index']);
    Route::post('/contact-info', [ContactInfoController::class, 'update']);



    // Hero slides
    Route::get('/hero-slides', [HeroSlideController::class, 'index']);
    Route::post('/hero-slides', [HeroSlideController::class, 'store']);
    Route::get('/hero-slides/{heroSlide}', [HeroSlideController::class, 'show']);
    Route::put('/hero-slides/{heroSlide}', [HeroSlideController::class, 'update']);
    Route::delete('/hero-slides/{heroSlide}', [HeroSlideController::class, 'destroy']);


    // Promo banners
    Route::get('/promo-banners', [PromoBannerController::class, 'index']);
    Route::post('/promo-banners', [PromoBannerController::class, 'store']);
    Route::get('/promo-banners/{promoBanner}', [PromoBannerController::class, 'show']);
    Route::put('/promo-banners/{promoBanner}', [PromoBannerController::class, 'update']);
    Route::delete('/promo-banners/{promoBanner}', [PromoBannerController::class, 'destroy']);


    // Stat items
    Route::get('/stat-items', [StatItemController::class, 'index']);
    Route::post('/stat-items', [StatItemController::class, 'store']);
    Route::get('/stat-items/{statItem}', [StatItemController::class, 'show']);
    Route::put('/stat-items/{statItem}', [StatItemController::class, 'update']);
    Route::delete('/stat-items/{statItem}', [StatItemController::class, 'destroy']);


    // About page
    Route::get('/about', [AboutController::class, 'index']);
    Route::post('/about', [AboutController::class, 'update']);


    // FAQ
    Route::get('/faq', [FaqController::class, 'index']);
    Route::post('/faq', [FaqController::class, 'update']);


    // Announcements
    Route::get('/announcements', [AnnouncementController::class, 'index']);
    Route::post('/announcements', [AnnouncementController::class, 'store']);
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show']);
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update']);
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy']);


    // Instagram
    Route::post('/instagram/settings', [InstagramController::class, 'updateSettings']);

    Route::get('/instagram/posts/{post}', [InstagramController::class, 'show']);
    Route::post('/instagram/posts', [InstagramController::class, 'store']);
    Route::post('/instagram/posts/{post}', [InstagramController::class, 'update']);
    Route::delete('/instagram/posts/{post}', [InstagramController::class, 'destroy']);

    
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

