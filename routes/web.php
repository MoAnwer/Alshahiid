<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MartyrController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return Auth::check() ? to_route('home') : to_route('login');
});

Route::view('/home', 'home')->name('home');

Route::controller(AuthController::class)->group(function() {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('loginAction');
    Route::post('register', 'register')->name('register');
    Route::get('logout', 'logout')->name('logout');
});



Route::middleware('auth')->group(function() {

	Route::controller(UserController::class)->prefix('users-management')->group(function(){
		Route::get('', 'index')->name('users.index');
		Route::get('create', 'create')->name('users.create');
		Route::post('store', 'store')->name('users.store');
		Route::get('edit/{id}', 'edit')->name('users.edit');
		Route::put('update/{id}', 'update')->name('users.update');
		Route::get('delete/{id}', 'delete')->name('users.delete');
		Route::delete('destroy/{id}', 'destroy')->name('users.destroy');
	});

	Route::controller(MartyrController::class)->prefix('martyrs')->group(function () {
		Route::get('', 'index')->name('martyrs.index');
		Route::get('create', 'create')->name('martyrs.create');
		Route::post('store', 'store')->name('martyrs.store');
		Route::get('edit/{id}', 'edit')->name('martyrs.edit');
		Route::put('update/{id}', 'update')->name('martyrs.update');
		Route::get('delete/{id}', 'delete')->name('martyrs.delete');
		Route::delete('destroy/{id}', 'destroy')->name('martyrs.destroy');

		Route::get('report', 'report')->name('reports.martyrs');
	});
	
	Route::controller(FamilyController::class)->prefix('families')->group(function () {
		Route::get('show/{id}', 'show')->name('families.show');
		Route::get('{martyr}/create', 'create')->name('families.create');
		Route::post('store/{martyr}', 'store')->name('families.store');
		Route::get('edit/{id}', 'edit')->name('families.edit');
		Route::put('update/{id}', 'update')->name('families.update');
		Route::get('delete/{id}', 'delete')->name('families.delete');
		Route::delete('destroy/{id}', 'destroy')->name('families.destroy');

		Route::get('supervisor/create/{id}', 'createSupervisor')->name('families.createSupervisor');
		Route::post('supervisor/store/{id}', 'storeSupervisor')->name('families.storeSupervisor');
		Route::get('supervisor/edit/{id}', 'editSupervisor')->name('families.editSupervisor');
		Route::put('supervisor/update/{id}', 'updateSupervisor')->name('families.updateSupervisor');
		Route::get('supervisor/delete/{id}', 'deleteSupervisor')->name('families.deleteSupervisor');
		Route::delete('supervisor/destroy/{id}', 'destroySupervisor')->name('families.destroySupervisor');

		Route::get('reports/families-categories', 'categoriesReport')->name('reports.familiesCategories');
  });
	
	Route::controller(ProjectController::class)->prefix('projects')->group(function() {
		Route::get('', 'index')->name('projects.index');
		Route::get('{family}/create', 'create')->name('projects.create');
		Route::get('{family}/edit/{project}', 'edit')->name('projects.edit');
		Route::post('store', 'store')->name('projects.store');
		Route::put('{family}/update/{project}', 'update')->name('projects.update');
		Route::get('delete/{id}', 'delete')->name('projects.delete');
		Route::delete('destroy/{id}', 'destroy')->name('projects.destroy');
	
		Route::get('report', 'report')->name('reports.projects');
		Route::get('projects-work-status-report', 'projectsWorkStatusReport')->name('reports.projectsWorkStatusReport');
	});

	Route::controller(FamilyMemberController::class)->prefix('family-members')->group(function() {
		Route::get('{family}/create', 'create')->middleware('check.family_size')->name('familyMembers.create');
		Route::get('{family}/edit/{member}', 'edit')->name('familyMembers.edit');
		Route::get('show/{member}', 'show')->name('familyMembers.show');
		Route::post('{family}/store', 'store')->name('familyMembers.store');
		Route::put('update/{member}', 'update')->name('familyMembers.update');
		Route::get('delete/{id}', 'delete')->name('familyMembers.delete');
		Route::delete('destroy/{id}', 'destroy')->name('familyMembers.destroy');

		Route::get('reports/family-members-count', 'familyMembersCountReport')->name('reports.familyMembersCount');
		Route::get(
			'reports/family-members-count-by-category', 
			'familyMembersCountByCategoryReport'
		)
		->name('reports.familyMembersCountByCategory');
	});
    
  Route::controller(AddressController::class)->prefix('address')->group(function() {
		Route::get('{family}/create', 'create')->name('address.create');
		Route::get('edit/{address}', 'edit')->name('address.edit');
		Route::put('{family}/update/{address}', 'update')->name('address.update');
		Route::post('{family}/store', 'store')->name('address.store');
		Route::get('delete/{address}', 'delete', 'delete')->name('address.delete');
		Route::delete('destroy/{id}', 'destroy')->name('address.destroy');

		Route::get('report', 'report')->name('reports.address');
  });
	
	Route::controller(HomeServiceController::class)->prefix('home-services')->group(function() {
		Route::get('{family}/create', 'create')->name('homes.create');
		Route::get('edit/{home}', 'edit')->name('homes.edit');
		Route::post('{family}/store', 'store')->name('homes.store');
		Route::put('{family}/update/{home}', 'update')->name('homes.update');
		Route::get('delete/{home}', 'delete')->name('homes.delete');
		Route::delete('destroy/{home}', 'destroy')->name('homes.destroy');
	});
	
	Route::controller(MedicalTreatmentController::class)->prefix('medical-treatments')->group(function() {
		Route::get('{member}/create', 'create')->name('medicalTreatment.create');
		Route::get('edit/{id}', 'edit')->name('medicalTreatment.edit');
		Route::post('store/{member}', 'store')->name('medicalTreatment.store');
		Route::put('update/{id}', 'update')->name('medicalTreatment.update');
		Route::get('delete/{id}', 'delete')->name('medicalTreatment.delete');
		Route::delete('destroy/{id}', 'destroy')->name('medicalTreatment.destroy');

		Route::get('report', 'report')->name('reports.medicalTreatment');
	});


	Route::controller(EducationServiceController::class)->prefix('education-services')->group(function() {
		Route::get('{member}/create', 'create')->name('educationServices.create');
		Route::get('edit/{id}', 'edit')->name('educationServices.edit');
		Route::post('store/{member}', 'store')->name('educationServices.store');
		Route::put('update/{id}', 'update')->name('educationServices.update');
		Route::get('delete/{id}', 'delete')->name('educationServices.delete');
		Route::delete('destroy/{id}', 'destroy')->name('educationServices.destroy');

		Route::get('report', 'report')->name('reports.educationServices');
	});
	

	Route::controller(StudentController::class)->prefix('students')->group(function() {
		Route::get('show/{student}', 'show')->name('students.show');
		Route::get('{member}/create', 'create')->name('students.create');
		Route::get('edit/{id}', 'edit')->name('students.edit');
		Route::post('store/{member}', 'store')->name('students.store');
		Route::put('update/{id}', 'update')->name('students.update');
		Route::get('delete/{id}', 'delete')->name('students.delete');
		Route::delete('destroy/{id}', 'destroy')->name('students.destroy');

		Route::get('report', 'report')->name('reports.students');
	});


	Route::controller(InjuredController::class)->prefix('injureds')->group(function() {
		Route::get('', 'index')->name('injureds.index');
		Route::get('show/{id}', 'show')->name('injureds.show');
		Route::get('create', 'create')->name('injureds.create');
		Route::post('store', 'store')->name('injureds.store');
		Route::get('edit/{id}', 'edit')->name('injureds.edit');
		Route::put('update/{id}', 'update')->name('injureds.update');
		Route::get('delete/{id}', 'delete')->name('injureds.delete');
		Route::delete('destroy/{id}', 'destroy')->name('injureds.destroy');
		
		Route::get('report', 'report')->name('reports.injureds');
		Route::get('injureds-tamiin', 'injuredsTamiin')->name('reports.injuredsTamiin');

	});
	
	Route::controller(InjuredServiceController::class)->prefix('injured-services')->group(function() {
		Route::get('', 'index')->name('injuredServices.index');
		Route::get('{injured}/create', 'create')->name('injuredServices.create');
		Route::post('{injured}/store', 'store')->name('injuredServices.store');
		Route::get('edit/{id}', 'edit')->name('injuredServices.edit');
		Route::put('update/{id}', 'update')->name('injuredServices.update');
		Route::get('delete/{id}', 'delete')->name('injuredServices.delete');
		Route::delete('destroy/{id}', 'destroy')->name('injuredServices.destroy');
		
		Route::get('report', 'report')->name('reports.injuredServices');
	});


	Route::controller(SupervisorController::class)->prefix('supervisors')->group(function () {
		Route::get('', 'index')->name('supervisors.index');
		Route::get('create', 'create')->name('supervisors.create');
		Route::get('show/{id}', 'show')->name('supervisors.show');
		Route::get('edit/{id}', 'edit')->name('supervisors.edit');
		Route::post('store', 'store')->name('supervisors.store');
		Route::put('update/{id}', 'update')->name('supervisors.update');
		Route::get('delete/{id}', 'delete')->name('supervisors.delete');
		Route::delete('destory/{id}', 'destory')->name('supervisors.destory');

	});

	Route::controller(AssistancesController::class)->prefix('assistances')->group(function() {
		Route::get('{family}', 'index')->name('assistances.index');
		Route::get('{family}/create', 'create')->name('assistances.create');
		Route::post('{family}/store', 'store')->name('assistances.store');
		Route::get('{family}/edit/{id}', 'edit')->name('assistances.edit');
		Route::put('{family}/update/{id}', 'update')->name('assistances.update');
		Route::get('delete/{id}', 'delete')->name('assistances.delete');
		Route::delete('destroy/{id}', 'destroy')->name('assistances.destroy');
	
	});

	// خليها هنا ما تدحلها مع اخوانا لانو بتجيب صفحة فاضية مع اخوانا
	Route::get('assistances-reports', 'AssistancesController@getReport')->name('reports.assistances');

});