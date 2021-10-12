<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::post('user_create','UserController@createUser');

// table user

Route::post('login', 'UserController@login')->name('login');
Route::post('register', 'UserController@register');

Route::group(['middleware' => 'auth:api'], function(){

	Route::get('user_details', 'UserController@getAllUser');
	Route::get('user/{id}', 'UserController@getUser');
	Route::put('user_update/{id}', 'UserController@updateUser');
	Route::delete('user_delete/{id}','UserController@deleteUser');
	Route::get('users/architect', 'UserController@getUser_Architect');
	Route::get('users/pmc', 'UserController@getUser_PMC');
	Route::get('users/client', 'UserController@getUser_Client');


	// Table Profile
	Route::post('profile_create','ProfileController@createProfile');
	Route::get('profile_details', 'ProfileController@getAllProfile');
	Route::get('profile/{id}', 'ProfileController@getProfile');
	Route::put('profile_update/{id}', 'ProfileController@updateProfile');
	Route::delete('profile_delete/{id}','ProfileController@deleteProfile');


	//Table Project
	Route::post('project_create','ProjectController@createProject');
	Route::get('project_details', 'ProjectController@getAllProject');
	Route::get('project/{id}', 'ProjectController@getProject');
	Route::put('project_update/{id}', 'ProjectController@updateProject');
	Route::delete('project_delete/{id}','ProjectController@deleteProject');

	// Table menu
	Route::post('menu_create','MenuController@createMenu');
	Route::get('menu_details', 'MenuController@getAllMenu');
	Route::get('menu/{id}', 'MenuController@getMenu');
	Route::put('menu_update/{id}', 'MenuController@updateMenu');
	Route::delete('menu_delete/{id}','MenuController@deleteMenu');

	// Table Permission

	Route::post('permission_create','PermissionController@createPermission');
	Route::get('permission_details', 'PermissionController@getAllPermission');
	Route::get('permission/{id}', 'PermissionController@getPermission');
	Route::put('permission_update/{id}', 'PermissionController@updatePermission');
	Route::delete('permission_delete/{id}','PermissionController@deletePermission');


	// Table Drawing
	Route::post('drawing_create','DrawingController@createDrawing');
	Route::get('drawing_details', 'DrawingController@getAllDrawing');
	Route::get('drawing/{id}', 'DrawingController@getDrawing');
	Route::post('drawing_update/{id}', 'DrawingController@updateDrawing');
	Route::delete('drawing_delete/{id}','DrawingController@deleteDrawing');

	// Table Photo
	Route::post('photo_create','PhotoController@createPhoto');
	Route::get('photo_details', 'PhotoController@getAllPhoto');
	Route::get('photo/{id}', 'PhotoController@getPhoto');
	Route::put('photo_update/{id}', 'PhotoController@updatePhoto');
	Route::delete('photo_delete/{id}','PhotoController@deletePhoto');

	// Table Status_report
	Route::post('status_report_create','Status_report_Controller@createStatus_report');
	Route::get('status_report_details', 'Status_report_Controller@getAllStatus_report');
	Route::get('status_report/{id}', 'Status_report_Controller@getStatus_report');
	Route::put('status_report_update/{id}', 'Status_report_Controller@updateStatus_report');
	Route::delete('status_report_delete/{id}','Status_report_Controller@deleteStatus_report');

	// Table Quotation
	Route::post('quotation_create','QuotationController@createQuotation');
	Route::get('quotation_details', 'QuotationController@getAllQuotation');
	Route::get('quotation/{id}', 'QuotationController@getQuotation');
	Route::put('quotation_update/{id}', 'QuotationController@updateQuotation');
	Route::delete('quotation_delete/{id}','QuotationController@deleteQuotation');

	// Table Note
	Route::post('note_create','NoteController@createNote');
	Route::get('note_details', 'NoteController@getAllNote');
	Route::get('note/{id}', 'NoteController@getNote');
	Route::put('note_update/{id}', 'NoteController@updateNote');
	Route::delete('note_delete/{id}','NoteController@deleteNote');

    Route::post('demo', 'UserController@demo');
});

//Route::post('demo', 'UserController@demo');