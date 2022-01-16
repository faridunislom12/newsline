<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Models\Article;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laratrust\LaratrustFacade;
use Laratrust\Laratrust;


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

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::post('/articles/get', [HomeController::class, 'getPublished'])->name('articles.get');

Route::middleware('auth')->group(function () {

    Route::get('logout', function () {
        Auth::logout();
        return redirect(route('auth.login'));
    })->name('logout');


    Route::group(['prefix' => 'admin'], function () {

        Route::get('/', function () {
            return Inertia::render('Index');
        })->name('index');

        Route::post('/notifications/get', function () {
            $articles = Article::where('publish_at', '>=', date('Y-m-d'))->orderBy('publish_at')->get();
            return response()->json([
                'articles' => $articles
            ]);
        })->name('notifications.get');

        Route::get('/users/{id}/access', [UserController::class, 'access'])->name('users.access');
        Route::post('/users/{user}/roles/change', [UserController::class, 'changeRoles'])->name('users.roles.change');
        Route::post('/users/{user}/permissions/change', [UserController::class, 'changePermissions'])->name('users.permissions.change');

        Route::get('/roles/{id}/access', [RoleController::class, 'access'])->name('roles.access');
        Route::post('/roles/{role}/users/change', [RoleController::class, 'changeUsers'])->name('roles.users.change');
        Route::post('/roles/{role}/permissions/change', [RoleController::class, 'changePermissions'])->name('roles.permissions.change');

//    Route::post('/users/grant/{user}', [UserController::class, 'grant'])->name('users.grant');
//    Route::post('/users/permissions/{user}', [UserController::class, 'permissions'])->name('users.permissions');

        $components = array(
            ["Permission", "permissions"],
            ["Role", "roles"],
            ["User", "users"],
            ["Article", "articles"],
            ["Category", "categories"]);

        $permission_actions = array(
            ["create", ['create', 'store']],
            ["read", ['index', 'show']],
            ["update", ['edit', 'update']],
            ["delete", ['destroy']]);

        foreach ($components as $component) {
            foreach ($permission_actions as $permission_action) {
                Route::resource('/' . $component[1], 'App\Http\Controllers\\' . $component[0] . 'Controller', [
                    'names' => $component,
                    'only' => $permission_action[1],
                    'middleware' => ['permission:' . $component[1] . '-' . $permission_action[0]]
                ]);
            }
        }
    });

// Auth
//    Route::middleware('auth')->group(function () {
//        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
//    });

});


// Auth
Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/check-login', [AuthController::class, 'checkLogin'])->name('auth.check-login');
    Route::post('/sign-in', [AuthController::class, 'signIn'])->name('auth.sign-in');
    Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'store'])->name('auth.register.store');
    Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password');
    Route::post('/confirm-password/{type}', [AuthController::class, 'confirmPassword'])->name('auth.confirm.password');
});




