<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PromotionCodeController as AdminPromotionCodeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardSettingController;
use App\Http\Controllers\DashboardTransactionController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserMemberController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Ajax\CartController as AjaxCartController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
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
Route::get('/admin/login', [AuthController::class, 'renderLogin'])->name('admin-login');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories-show');

Route::get('/detail/{id}', [DetailController::class, 'index'])->name('detail');
Route::post('/detail/{product}', [DetailController::class, 'add'])->name('detail-add');

Route::get('/success', [CartController::class, 'success'])->name('cart-success');

Route::post('/checkout/callback', [CheckoutController::class, 'callback'])->name('midtrans-callback');
//register user
Route::get('/register/success', [UserMemberController::class, 'success'])->name('register-success');
Route::get('/register/create', [UserMemberController::class, 'create'])->name('register-user');
Route::post('/register/store', [UserMemberController::class, 'store'])->name('register-user-store');

Route::group(['middleware' => ['auth']], function () {
    //Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::delete('/delete/{cart}', [CartController::class, 'delete'])->name('cart-delete');

    //Checkout
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout');

    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //product
    Route::get('/dashboard/product', [DashboardProductController::class, 'index'])->name('dashboard-product');
    Route::get('/dashboard/products/create', [DashboardProductController::class, 'create'])->name('dashboard-product-create');
    Route::post('/dashboard/products/store', [DashboardProductController::class, 'store'])->name('dashboard-product-store');
    Route::post('/dashboard/products/update/{product}', [DashboardProductController::class, 'update'])->name('dashboard-product-update');
    Route::get('/dashboard/products/details/{product}', [DashboardProductController::class, 'details'])->name('dashboard-product-details');

    //Upload Product Images
    Route::post('/dashboard/products/image/upload', [DashboardProductController::class, 'uploadImage'])->name('dashboard-product-upload-image');
    Route::get('/dashboard/products/image/delete/{product_image}', [DashboardProductController::class, 'deleteImage'])->name('dashboard-product-delete-image');

    //transaction
    Route::get('/dashboard/transactions', [DashboardTransactionController::class, 'index'])->name('dashboard-transactions');
    Route::get('/dashboard/transactions/{id}', [DashboardTransactionController::class, 'details'])->name('dashboard-transactions-details');
    Route::post('/dashboard/transactions/update/{transaction_detail}', [DashboardTransactionController::class, 'update'])->name('dashboard-transactions-update');

    //setting
    Route::get('/dashboard/settings', [DashboardSettingController::class, 'store'])->name('dashboard-store-settings');
    Route::get('/dashboard/accounts', [DashboardSettingController::class, 'account'])->name('dashboard-account-settings');
    Route::post('/dashboard/store-settings/{redirect}', [DashboardSettingController::class, 'updateStore'])->name('dashboard-store-settings-update');
    Route::post('/dashboard/accounts/{redirect}', [DashboardSettingController::class, 'updateAccount'])->name('dashboard-account-settings-update');
});

Route::prefix('admin')
    ->namespace('admin')
    ->group(function () {
        Route::prefix('auth')->group(function () {
            Route::get('/login', [AuthController::class, 'renderLogin'])->name('login');
            Route::post('/login', [AuthController::class, 'login'])->name('login.admin');
    
            Route::get('/logout', [AuthController::class, 'logout'])->name('logout.admin');
        });

        Route::middleware(['auth', 'admin'])->group(function () {
            Route::get('/', [AdminDashboardController::class, 'index'])->name('admin-dashboard');

            //users
            Route::get('/user', [AdminUserController::class, 'index'])->name('admin-user.index');
            Route::get('/user/create', [AdminUserController::class, 'create'])->name('admin-user.create');
            Route::post('/user/store', [AdminUserController::class, 'store'])->name('admin-user.store');
            Route::get('/user/{user}/show', [AdminUserController::class, 'show'])->name('admin-user.show');
            Route::get('/user/{user}/edit', [AdminUserController::class, 'edit'])->name('admin-user.edit');
            Route::patch('/user/{user}/update', [AdminUserController::class, 'update'])->name('admin-user.update');
            Route::delete('/user/{user}/delete', [AdminUserController::class, 'destroy'])->name('admin-user.delete');

            //profiles admin
            Route::get('/{user}/profile', [AdminUserController::class, 'profile'])->name('admin-profile');
            Route::get('/{user}/profile/edit', [AdminUserController::class, 'profileEdit'])->name('admin-profile.edit');
            Route::patch('/admin-profile', [AdminUserController::class, 'profileUpdate'])->name('admin-profile.update');

            //categories
            Route::get('/category', [AdminCategoryController::class, 'index'])->name('admin-category.index');
            Route::get('/category/create', [AdminCategoryController::class, 'create'])->name('admin-category.create');
            Route::post('/category/store', [AdminCategoryController::class, 'store'])->name('admin-category.store');
            Route::get('/category/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin-category.edit');
            Route::patch('/category/{category}/update', [AdminCategoryController::class, 'update'])->name('admin-category.update');
            Route::delete('/category/{category}/delete', [AdminCategoryController::class, 'destroy'])->name('admin-category.delete');
    
            //products
            Route::get('/product', [AdminProductController::class, 'index'])->name('admin-product.index');
            Route::get('/product/create', [AdminProductController::class, 'create'])->name('admin-product.create');
            Route::post('/product/store', [AdminProductController::class, 'store'])->name('admin-product.store');
            Route::get('/product/{product}/edit', [AdminProductController::class, 'edit'])->name('admin-product.edit');
            Route::patch('/product/{product}/update', [AdminProductController::class, 'update'])->name('admin-product.update');
            Route::delete('/product/{product}/delete', [AdminProductController::class, 'destroy'])->name('admin-product.delete');
    
            //transactions
            Route::get('/transaction', [AdminTransactionController::class, 'index'])->name('admin-transaction.index');
            Route::get('/transaction/{transaction}/edit', [AdminTransactionController::class, 'edit'])->name('admin-transaction.edit');
            Route::patch('transaction/{transaction}/update', [AdminTransactionController::class, 'update'])->name('admin-transaction.update');
            Route::delete('/transaction/{transaction}/delete', [AdminTransactionController::class, 'destroy'])->name('admin-transaction.delete');

            //promotion codes
            Route::get('/promotion-code', [AdminPromotionCodeController::class, 'index'])->name('admin-promocode.index');
            Route::get('/promotion-code/create', [AdminPromotionCodeController::class, 'create'])->name('admin-promocode.create');
            Route::post('/promotion-code/store', [AdminPromotionCodeController::class, 'store'])->name('admin-promocode.store');
            Route::get('/promotion-code/edit/{promotion_code}', [AdminPromotionCodeController::class, 'edit'])->name('admin-promocode.edit');
            Route::patch('/promotion-code/update/{promotion_code}', [AdminPromotionCodeController::class, 'update'])->name('admin-promocode.update');
            Route::delete('/promotion-code/delete/{promotion_code}', [AdminPromotionCodeController::class, 'destroy'])->name('admin-promocode.delete');
        });
    });

Auth::routes();
