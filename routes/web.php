<?php

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

use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Annotation\Route as SymfonyRoute;


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/print-pdf','ReabastecerController@printPDF')->name('customer.printpdf');
Route::post('addCarrito', 'PrecompraController@Carrito')->name('Precompra.addcarrito');
Route::post('TipoVenta', 'PrecompraController@TipoVenta')->name('Precompra.TipoVenta');
Route::get('TimeUP', 'PrecompraController@TimeIsUpPrecompra')->name('Precompra.TimeUP');
Route::get('Carrito', 'PrecompraController@index');



////////////CLIENTE//////////////////
Route::resource('producto', 'ProductoController');
Route::post('update_post', 'ProductoController@update_post');


Route::resource('reabastecer', 'ReabastecerController');

Route::resource('historialVenta', 'AbonoController');
Route::post('adeudoClientes','AbonoController@adeudoClientes');
Route::post('abonoCliente','AbonoController@abonoCliente');

Route::get('/historialCorte','AbonoController@historial_Corte_ventas');



Route::get('restablecerTipoVenta', 'VentaController@restablecerTipoVenta')->name('venta.restablecerTipoVenta');
Route::post('search_cliente','VentaController@search_cliente');
Route::post('borrar_producto','VentaController@borrar_producto');
Route::post('buscarProducto', 'VentaController@buscarProducto');
Route::resource('venta', 'VentaController');


Route::resource('cliente', 'ClienteController');
Route::get('listarclientes','ClienteController@listar');
Route::post('clienteupdate','ClienteController@updateCliente');

