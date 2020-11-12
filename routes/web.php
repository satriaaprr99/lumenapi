<?php
use Illuminate\Support\Str;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('siswa', 'SiswaController@index');
$router->post('siswa', 'SiswaController@create');
$router->get('siswa/{id}', 'SiswaController@show');
$router->put('siswa/{id}', 'SiswaController@update');
$router->delete('siswa/{id}', 'SiswaController@destroy');
$router->get('siswa/avatar/{name}', 'SiswaController@get_avatar');
$router->get('siswabayar/{id}', 'TransaksiController@SiswaBayar');

$router->get('kelas', 'KelasController@index');
$router->post('kelas', 'KelasController@create');
$router->get('kelas/{id}', 'KelasController@show');
$router->put('kelas/{id}', 'KelasController@update');
$router->delete('kelas/{id}', 'KelasController@destroy');

$router->get('angkatan', 'AngkatanController@index');
$router->post('angkatan', 'AngkatanController@create');
$router->get('angkatan/{id}', 'AngkatanController@show');
$router->put('angkatan/{id}', 'AngkatanController@update');
$router->delete('angkatan/{id}', 'AngkatanController@destroy');

$router->get('tagihan', 'TagihanController@index');
$router->post('tagihan', 'TagihanController@create');
$router->get('tagihan/{id}', 'TagihanController@show');
$router->put('tagihan/{id}', 'TagihanController@update');
$router->delete('tagihan/{id}', 'TagihanController@destroy');

$router->get('transaksi', 'TransaksiController@index');
$router->post('transaksi', 'TransaksiController@create');
$router->get('transaksi/{id}', 'TransaksiController@show');
$router->put('transaksi/{id}', 'TransaksiController@update');
$router->delete('transaksi/{id}', 'TransaksiController@destroy');
$router->get('histori', 'TransaksiController@histori');

$router->post('login', 'AuthController@login');
$router->post('register', 'AuthController@register');