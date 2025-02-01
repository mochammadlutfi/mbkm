<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/','HomeController@index')->name('home');
Route::get('/tentang-kami','HomeController@about')->name('about');

Route::get('/login','AuthController@showLogin')->name('login');
Route::post('/login','AuthController@login');
Route::get('/daftar','AuthController@showRegister')->name('register');
Route::post('/daftar','AuthController@register');


Route::prefix('/program')->name('program.')->group(function () {
    Route::get('/','ProgramController@index')->name('index');
    Route::get('/{slug}','ProgramController@show')->name('show');
});
Route::middleware('auth')->group(function () {
    Route::post('/keluar','AuthController@logout')->name('logout');
    
    Route::name('profil.')->group(function () {
        Route::get('/profil','ProfilController@edit')->name('edit');
        Route::post('/profil','ProfilController@update');
        
        Route::get('/password','ProfilController@password')->name('password');
        Route::post('/password','ProfilController@updatePassword');
    });
        
    Route::get('/pendaftaran','ProgramController@user')->name('user.program');
    Route::get('/pendaftaran/{id}','ProgramController@userShow')->name('user.program.show');
    Route::post('/program/simpan','ProgramController@register')->name('program.register');
    
});

Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function(){
    
    Route::middleware('guest:admin')->group(function () {
        Route::get('/','LoginController@showLoginForm')->name('login');
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login');
    });

    Route::middleware(['auth:admin'])->group(function () {
        Route::post('/logout','LoginController@logout')->name('logout');

        Route::get('/profile','ProfileController@index')->name('profile.edit');
        Route::post('/profile','ProfileController@update')->name('profile.update');
        Route::get('/password','ProfileController@password')->name('password');
        Route::post('/password','ProfileController@passwordUpdate')->name('password.update');

        Route::middleware('verified')->group(function () {
            Route::get('/beranda','BerandaController@index')->name('beranda');
            
            Route::prefix('/mahasiswa')->name('user.')->group(function () {
                Route::get('/','UserController@index')->name('index');
                Route::get('/create','UserController@create')->name('create');
                Route::post('/store','UserController@store')->name('store');
                Route::get('/json/{id}','UserController@json')->name('json');
                Route::get('/{id}','UserController@show')->name('show');
                Route::get('/{id}/edit','UserController@edit')->name('edit');
                Route::post('{id}/update','UserController@update')->name('update');
                Route::post('{id}/password','UserController@password')->name('password');
                Route::delete('/{id}/delete','UserController@destroy')->name('delete');
                Route::get('/{id}/riwayat','UserController@riwayat')->name('riwayat');
            });

            Route::prefix('/program')->name('program.')->group(function () {
                Route::get('/','ProgramController@index')->name('index');
                Route::get('/create','ProgramController@create')->name('create');
                Route::post('/store','ProgramController@store')->name('store');
                Route::post('/status','ProgramController@status')->name('status');
                Route::get('/{id}','ProgramController@show')->name('show');
                Route::get('/{id}/edit','ProgramController@edit')->name('edit');
                Route::post('{id}/update','ProgramController@update')->name('update');
                Route::delete('/{id}/delete','ProgramController@destroy')->name('delete');
                Route::get('/{id}/peserta','UserProgramController@index')->name('peserta');
                Route::post('/{id}/peserta/store','UserProgramController@store')->name('peserta.store');
                Route::delete('/{id}/peserta/delete','UserProgramController@destroy')->name('peserta.delete');
                Route::get('/{id}/peserta/{user}/certificate','UserProgramController@certificate')->name('peserta.certificate');
            });
            
            Route::prefix('/kategori')->name('kategori.')->group(function () {
                Route::get('/','KategoriController@index')->name('index');
                Route::post('/store','KategoriController@store')->name('store');
                Route::get('/{id}','KategoriController@show')->name('show');
                Route::get('/{id}/edit','KategoriController@edit')->name('edit');
                Route::post('/{id}/update','KategoriController@update')->name('store');
                Route::delete('/{id}/delete','KategoriController@destroy')->name('delete');
            });

            Route::prefix('/matkul')->name('matkul.')->group(function () {
                Route::get('/','MatkulController@index')->name('index');
                Route::post('/store','MatkulController@store')->name('store');
                Route::get('/{id}','MatkulController@show')->name('show');
                Route::get('/{id}/edit','MatkulController@edit')->name('edit');
                Route::post('/{id}/update','MatkulController@update')->name('store');
                Route::delete('/{id}/delete','MatkulController@destroy')->name('delete');
            });

            Route::prefix('/pendaftaran')->name('register.')->group(function () {
                Route::get('/','RegisterController@index')->name('index');
                Route::post('/select','RegisterController@select')->name('select');
                Route::get('/create','RegisterController@create')->name('create');
                Route::post('/store','RegisterController@store')->name('store');
                Route::get('/{id}','RegisterController@show')->name('show');
                Route::get('/{id}/edit','RegisterController@edit')->name('edit');
                Route::post('{id}/update','RegisterController@update')->name('update');
                Route::post('{id}/status','RegisterController@status')->name('status');
                Route::delete('/{id}/delete','RegisterController@destroy')->name('delete');
            });
        
            Route::prefix('/konversi')->name('konversi.')->group(function () {
                Route::get('/','KonversiController@index')->name('index');
                Route::get('/create','KonversiController@create')->name('create');
                Route::post('/store','KonversiController@store')->name('store');
                Route::get('/{id}','KonversiController@show')->name('show');
                Route::get('/{id}/pdf','KonversiController@pdf')->name('pdf');
                Route::get('/{id}/edit','KonversiController@edit')->name('edit');
                Route::post('{id}/update','KonversiController@update')->name('update');
                Route::delete('/{id}/delete','KonversiController@destroy')->name('delete');
            });
            

            Route::prefix('/pegawai')->name('pegawai.')->group(function () {
                Route::get('/','PegawaiController@index')->name('index');
                Route::get('/data','PegawaiController@data')->name('data');
                Route::get('/create','PegawaiController@create')->name('create');
                Route::post('/store','PegawaiController@store')->name('store');
                Route::get('/{id}','PegawaiController@show')->name('show');
                Route::get('/{id}/edit','PegawaiController@edit')->name('edit');
                Route::post('{id}/update','PegawaiController@update')->name('update');
                Route::delete('/{id}/delete','PegawaiController@destroy')->name('delete');
            });

            

        });
    });
});


// require __DIR__.'/auth.php';
