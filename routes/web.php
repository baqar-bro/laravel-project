<?php

use App\Http\Controllers\AccountInteractivityController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\EmailsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthUser;
use App\Models\Comments;

Route::get('/', function () {
    return view('splash');
})->name('splashpage');

Route::get('/welcometocloud', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['web'])->group(function () {
    Route::post('/create/account', [UserAccountController::class, 'createAccount'])->name('create.account');
});

Route::controller(PostsController::class)->group(function () {

    Route::get('post', function () {
        return view('posts.postform');
    })->name('post.something')->middleware(AuthUser::class);

    Route::post('/posting', 'insertpostdata')->middleware(AuthUser::class);
    Route::get('/load/post/{page}', 'loadposts');
});

Route::get('/user/account', function () {
    return view('user_account.account_form');
})->name('user.account');

Route::get('/search/user/acc', function () {
    return view('user_account.search_acc');
})->name('search.account');

Route::controller(UserAccountController::class)->group(function () {

    Route::get('getting/acc', 'getallaccounts')->name('get.all.accounts');
    Route::get('/get/acc/by/name/{name}', 'getsearchaccount');
    Route::get('/user/account/info', 'accountinfo')->name('user.account.info');
    Route::get('/search/user/{name}', 'accountfilter');
});

Route::controller(AccountInteractivityController::class)->group(function () {

    Route::post('/account/interacitivity', 'accountinteractivity')->name('account.interactivity')->middleware(AuthUser::class);;
    Route::post('/check/following', 'checkfollowing')->name('account.check.following');
    Route::post('/account/unfollow', 'unfollow')->name('account.unfollow')->middleware(AuthUser::class);;
});

Route::controller(NotifyController::class)->group(function () {
    Route::get('/see/notifications' , function(){
        return view('notify.notify');
    })->name('notify.user')->middleware(AuthUser::class);
    Route::get('/notifications', 'notifications');
});

Route::controller(LikesController::class)->group(function () {

    Route::post('/like/post', 'likeinteractivity')->middleware(AuthUser::class);
    Route::get('/check/like/{id}', 'checkLike');
});

Route::controller(CommentsController::class)->group(function () {

    Route::get('/comments/load/{id}/{page}', 'getComments');
    Route::post('/comment/post' , 'postComment')->middleware(AuthUser::class);
});

Route::controller(BookmarkController::class)->group(function(){

    Route::post('save/bookmark' , 'postbookmark')->middleware(AuthUser::class);
    Route::get('check/bookmark/{id}' , 'checkbookmark');
});

Route::controller(NotifyController::class)->group(function(){
    Route::get('/get/notifications' , 'notifications')->middleware(AuthUser::class);
});

Route::get('/show/account', function () {
    return view('user_account.account_info');
})->middleware(AuthUser::class)->name('show.user.account');

Route::controller(UserController::class)->group(function () {
    Route::get('register', 'index')->name('register');
    Route::get('login', 'login')->name('login');
    Route::Post('add', 'addUser');
    Route::post('auth', 'auth');
    Route::get('forgot', 'verification')->name('forgot.pass');
    Route::get('/reset/page/{token}/{email}', 'resetpasswordform')->name('reset.page');
    Route::post('reset/pass', 'resetpass')->name('reset.pass');
    Route::get('logout', 'logout');
});

Route::controller(EmailsController::class)->group(
    function () {
        Route::get('/email/verify', 'sendmail')->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', 'verifymail')->name('verification.verify');
        Route::post('/resend/notification', 'resendemail')->name('verification.send');
        Route::post('/email/verify', 'resetpasswordlink')->name('email.verify');
    }
);
