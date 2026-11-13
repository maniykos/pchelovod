<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GalleryController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
    Route::redirect('/catalog', '/products')->name('products.catalog');
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('/contacts/order', [ContactController::class, 'store'])->name('contacts.order');
    Route::get('/locale/{locale}', LocaleController::class)->name('locale');

    Route::get('/admin/login', [AuthController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'store'])->name('admin.login.store');
    Route::post('/admin/logout', [AuthController::class, 'destroy'])->name('admin.logout');

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', AdminProductController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('blog', AdminBlogController::class)->parameters(['blog' => 'post'])->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('certificates', AdminCertificateController::class)->parameters(['certificates' => 'certificate'])->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('gallery', AdminGalleryController::class)->parameters(['gallery' => 'galleryItem'])->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::get('/contacts', [AdminContactController::class, 'edit'])->name('contacts.edit');
        Route::put('/contacts', [AdminContactController::class, 'update'])->name('contacts.update');
        Route::redirect('/content', '/admin/contacts')->name('content');
    });
});
