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

// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

//Rutas de Pagina Principal
Route::view('ceifor', 'admin/dashboard')->name('admindashboard');

//Rutas de Paginas Charts
Route::view('chartjs', 'charts/chartjs')->name('chartsjs');

//Rutas de Paginas Calendar
Route::view('calendar', 'calendar/calendar')->name('calendar');

//Rutas de Paginas Mails
Route::view('inbox', 'mail/mailbox')->name('mailinbox');

Route::view('compose', 'mail/compose')->name('mailcompose');

Route::view('sent', 'mail/sent')->name('mailsent');

Route::view('read', 'mail/read-mail/{$id}')->name('mailread');

// Ruta listar correos inbox
Route::get('inbox', 'MailController@getInbox')->name('mailinbox');

// Ruta de eliminar correos:
Route::delete('read/{id}', 'MailController@destroy')->name('read.destroy');

// listado ruta de correos enviados
Route::get('sent', 'MailController@sent')->name('mailsent');

// ruta de lectura de correo por el id
Route::get('/read/{id}', 'MailController@read')->name('mailread');

// ruta al enviar correo
Route::post('/send', 'MailController@send')->name('email');
   
// ruta al enviar correo a grupos
Route::get('send-all', 'MailController@sendAll');

// Listado de Rutas de Eventos
// Route::resource('event', 'EventController');

// Ruta de muestra de Eventos en clendario
// Route::get('calendar/show','EventController@show')->name('eventshow');

// Ruta crear Evento
Route::post('claendar/create','EventController@create');

// Ruta de los detalles del Evento
Route::get('calendar/details/{id}','EventController@details')->name('eventdetails');

Route::delete('details/{id}','EventController@destroy')->name('eventdetails');




// Rutas de Socialite login y register con google
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');

Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

// Rutas de la Auth:
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes(['reset' => false]);

Route::resource('mail', 'MailController')->middleware('auth');