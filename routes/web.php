<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MartyrController;
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

Route::get('/', function () {
    return Auth::check() ? to_route('home') : to_route('login');
});

Route::controller(AuthController::class)->group(function() {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('loginAction');
    Route::post('register', 'register')->name('register');
    Route::get('logout', 'logout')->name('logout');
});



Route::middleware('auth')->group(function() {

	Route::view('home', 'home')->name('home');

	Route::controller(UserController::class)->prefix('users-management')->group(function(){
		Route::get('', 'index')->name('users.index');
		Route::get('userLog/{user}', 'userLog')->name('users.userLog');
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
		Route::get('{martyr}/relate-to-family', 'relateToFamilyPage')->name('martyrs.relateToFamilyPage');
		Route::post('{martyr}/relate-to-family-action', 'relateToFamilyAction')->name('martyrs.relateToFamilyAction');
		Route::get('report', 'report')->name('reports.martyrs');
	});
	
	Route::controller(FamilyController::class)->prefix('families')->group(function () {
		Route::get('list', 'index')->name('families.list');
		Route::get('family-members-count', 'familiesMembersCount')->name('families.index');
		Route::get('show/{id}', 'show')->name('families.show');
		Route::get('{martyr}/create', 'create')->name('families.create');
		Route::post('store/{martyr}', 'store')->name('families.store');
		Route::get('edit/{id}', 'edit')->name('families.edit');
		Route::put('update/{id}', 'update')->name('families.update');
		Route::get('delete/{id}', 'delete')->name('families.delete');
		Route::delete('destroy/{id}', 'destroy')->name('families.destroy');
		
		Route::get('{id}/social-services', 'socialServices')->name('families.socialServices');
		Route::get('{id}/relatedMartyrs', 'relatedMartyrs')->name('families.relatedMartyrs');

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
		Route::get('{family}/list', 'family')->name('projects.family');
		Route::get('{family}/create', 'create')->name('projects.create');
		Route::get('edit/{id}', 'edit')->name('projects.edit');
		Route::post('{family}/store', 'store')->name('projects.store');
		Route::put('update/{id}', 'update')->name('projects.update');
		Route::get('delete/{id}', 'delete')->name('projects.delete');
		Route::delete('destroy/{id}', 'destroy')->name('projects.destroy');
	
		Route::get('report', 'report')->name('reports.projects');
		Route::get('projects-work-status-report', 'projectsWorkStatusReport')->name('reports.projectsWorkStatusReport');
	});

	Route::controller(FamilyMemberController::class)->prefix('family-members')->group(function() {
		Route::get('{family}/create', 'create')->middleware('check.family_size')->name('familyMembers.create');
		Route::get('edit/{member}', 'edit')->name('familyMembers.edit');
		Route::get('show/{member}', 'show')->name('familyMembers.show');
		Route::post('{family}/store', 'store')->name('familyMembers.store');
		Route::put('update/{member}', 'update')->name('familyMembers.update');
		Route::get('delete/{id}', 'delete')->name('familyMembers.delete');
		Route::delete('destroy/{id}', 'destroy')->name('familyMembers.destroy');

		Route::get('reports/family-members-count', 'familyMembersCountReport')->name('reports.familyMembersCount');
		Route::get('reports/family-members-count-by-category', 'familyMembersCountByCategoryReport')
		->name('reports.familyMembersCountByCategory');
		Route::get('reports/orphans', 'orphanReport')->name('reports.orphanReport');

	});

	Route::controller(WidowController::class)->prefix('widows')->group(function() {

			Route::get('', 'widows')->name('widows.index');
			
	});

	Route::controller(OrphanController::class)->prefix('orphans')->group(function() {

		Route::get('', 'index')->name('orphans.index');
		Route::get('list', 'orphansList')->name('orphans.list');
		Route::get('hags', 'hags')->name('orphans.hags');
		Route::get('education-report', 'education')->name('orphans.education');
		Route::get('medical-report', 'medical')->name('orphans.medical');
			
	});
    

  Route::controller(AddressController::class)->prefix('address')->group(function() {
		Route::get('{family}/create', 'create')->name('address.create');
		Route::get('edit/{address}', 'edit')->name('address.edit');
		Route::put('update/{address}', 'update')->name('address.update');
		Route::post('{family}/store', 'store')->name('address.store');
		Route::get('delete/{address}', 'delete', 'delete')->name('address.delete');
		Route::delete('destroy/{id}', 'destroy')->name('address.destroy');

		Route::get('report', 'report')->name('reports.address');
  });
	
	Route::controller(HomeServiceController::class)->prefix('home-services')->group(function() {
		// Route::get('', 'index')->name('homes.index');
		Route::get('{family}/create', 'create')->name('homes.create');
		Route::get('edit/{home}', 'edit')->name('homes.edit');
		Route::post('{family}/store', 'store')->name('homes.store');
		Route::put('{family}/update/{home}', 'update')->name('homes.update');
		Route::get('delete/{home}', 'delete')->name('homes.delete');
		Route::delete('destroy/{home}', 'destroy')->name('homes.destroy');

		Route::get('report', 'report')->name('reports.homes');
	});
	
	Route::controller(MedicalTreatmentController::class)->prefix('medical-treatments')->group(function() {
		Route::get('', 'index')->name('medicalTreatment.index');
		Route::get('tamiin', 'tamiin')->name('medicalTreatment.tamiin');
		Route::get('tamiin-list', 'tamiinList')->name('medicalTreatment.tamiinList');
		Route::get('{member}/create', 'create')->name('medicalTreatment.create');
		Route::get('edit/{id}', 'edit')->name('medicalTreatment.edit');
		Route::post('store/{member}', 'store')->name('medicalTreatment.store');
		Route::put('update/{id}', 'update')->name('medicalTreatment.update');
		Route::get('delete/{id}', 'delete')->name('medicalTreatment.delete');
		Route::delete('destroy/{id}', 'destroy')->name('medicalTreatment.destroy');

		Route::get('report', 'report')->name('reports.medicalTreatment');
		
	});


	Route::controller(EducationServiceController::class)->prefix('education-services')->group(function() {
		Route::get('', 'index')->name('educationServices.index');
		Route::get('{member}/create', 'create')->name('educationServices.create');
		Route::get('edit/{id}', 'edit')->name('educationServices.edit');
		Route::post('store/{member}', 'store')->name('educationServices.store');
		Route::put('update/{id}', 'update')->name('educationServices.update');
		Route::get('delete/{id}', 'delete')->name('educationServices.delete');
		Route::delete('destroy/{id}', 'destroy')->name('educationServices.destroy');

		Route::get('report', 'report')->name('reports.educationServices');
	});
	

	Route::controller(StudentController::class)->prefix('students')->group(function() {
		Route::get('', 'index')->name('students.index');
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
		Route::delete('destroy/{id}', 'destroy')->name('supervisors.destroy');

		Route::get('supervisor/{id}/families', 'families')->name('supervisors.families');

	});

	Route::controller(AssistancesController::class)->prefix('assistances')->group(function() {
		Route::get('', 'index')->name('assistances.index');
		Route::get('{family}/list', 'family')->name('assistances.family');
		Route::get('{family}/create', 'create')->name('assistances.create');
		Route::post('{family}/store', 'store')->name('assistances.store');
		Route::get('{family}/edit/{id}', 'edit')->name('assistances.edit');
		Route::put('update/{id}', 'update')->name('assistances.update');
		Route::get('delete/{id}', 'delete')->name('assistances.delete');
		Route::delete('destroy/{id}', 'destroy')->name('assistances.destroy');
	
	});

	// خليها هنا ما تدخلها مع اخوانا لانو بتجيب صفحة فاضية مع اخوانا
	Route::get('assistances-reports', 'AssistancesController@getReport')->name('reports.assistances');


	Route::controller(BailController::class)->prefix('bails')->group(function () {
		Route::get('index', 'index')->name('bails.index');
		Route::get('{family}/monthly-bails', 'show')->name('families.bails');
		Route::get('{family}/create', 'create')->name('bails.create');
		Route::get('edit/{id}', 'edit')->name('bails.edit');
		Route::put('update/{id}', 'update')->name('bails.update');
		Route::post('store/{family}', 'store')->name('bails.store');
		Route::get('delete/{id}', 'delete')->name('bails.delete');
		Route::delete('destroy/{id}', 'destroy')->name('bails.destroy');

		Route::get('report', 'report')->name('reports.bails');
	});

	Route::controller(DocumentController::class)->prefix('documents')->group(function () {
		Route::get('{family}/family-documents', 'familyDocuments')->name('documents.show');
		Route::get('{family}/create', 'create')->name('documents.create');
		Route::post('store/{family}', 'store')->name('documents.store');
		Route::get('edit/{id}', 'edit')->name('documents.edit');
		Route::put('update/{id}', 'update')->name('documents.update');
		Route::get('delete/{id}', 'delete')->name('documents.delete');
		Route::delete('destroy/{id}', 'destroy')->name('documents.destroy');
	});


	
	Route::controller(FamilyMemberDocumentController::class)->prefix('member-documents')->group(function () {

		Route::get('{member}/create', 'create')->name('familyMemberDocuments.create');
		Route::post('store/{member}', 'store')->name('familyMemberDocuments.store');
		Route::get('edit/{id}', 'edit')->name('familyMemberDocuments.edit');
		Route::put('update/{id}', 'update')->name('familyMemberDocuments.update');
		Route::get('delete/{id}', 'delete')->name('familyMemberDocuments.delete');
		Route::delete('destroy/{id}', 'destroy')->name('familyMemberDocuments.destroy');

	});

	Route::controller(MarryAssistanceController::class)->prefix('marry-assistances')->group(function () {

		Route::get('{member}/create', 'create')->name('marryAssistances.create');
		Route::post('store/{member}', 'store')->name('marryAssistances.store');
		Route::get('edit/{id}', 'edit')->name('marryAssistances.edit');
		Route::put('update/{id}', 'update')->name('marryAssistances.update');
		Route::get('delete/{id}', 'delete')->name('marryAssistances.delete');
		Route::delete('destroy/{id}', 'destroy')->name('marryAssistances.destroy');

		Route::get('report', 'report')->name('marryAssistances.report');

	});
	
		// التزكية الروحية

		Route::view('tazkiia', 'tazkiia.index')->name('tazkiia.index');

		Route::controller(HagController::class)->prefix('tazkiia/hag-and-ommrah')->group(function () {

			Route::get('{member}/create', 'create')->name('tazkiia.hagAndOmmrah.create');
			Route::post('store/{member}', 'store')->name('tazkiia.hagAndOmmrah.store');
			Route::get('edit/{id}', 'edit')->name('tazkiia.hagAndOmmrah.edit');
			Route::put('{id}/update', 'update')->name('tazkiia.hagAndOmmrah.update');
			Route::get('delete/{id}', 'delete')->name('tazkiia.hagAndOmmrah.delete');
			Route::delete('destroy/{id}', 'destroy')->name('tazkiia.hagAndOmmrah.destroy');

		});

		Route::controller(SessionController::class)->prefix('tazkiia/sessions')->group(function () {

			Route::get('', 'index')->name('tazkiia.sessions.index');
			Route::get('create', 'create')->name('tazkiia.sessions.create');
			Route::post('store', 'store')->name('tazkiia.sessions.store');
			Route::get('edit/{id}', 'edit')->name('tazkiia.sessions.edit');
			Route::put('{id}/update', 'update')->name('tazkiia.sessions.update');
			Route::get('delete/{id}', 'delete')->name('tazkiia.sessions.delete');
			Route::delete('destroy/{id}', 'destroy')->name('tazkiia.sessions.destroy');

		});



		Route::controller(CampController::class)->prefix('tazkiia/camps')->group(function () {

			Route::get('', 'index')->name('tazkiia.camps.index');
			Route::get('create', 'create')->name('tazkiia.camps.create');
			Route::post('store', 'store')->name('tazkiia.camps.store');
			Route::get('edit/{id}', 'edit')->name('tazkiia.camps.edit');
			Route::put('{id}/update', 'update')->name('tazkiia.camps.update');
			Route::get('delete/{id}', 'delete')->name('tazkiia.camps.delete');
			Route::delete('destroy/{id}', 'destroy')->name('tazkiia.camps.destroy');

		});



		Route::controller(MartyrCommunicateController::class)->prefix('tazkiia/martyr-family-communicate')->group(function () {

			Route::get('', 'index')->name('tazkiia.communicate.index');
			Route::get('{family}/create', 'create')->name('tazkiia.communicate.create');
			Route::post('{family}/store', 'store')->name('tazkiia.communicate.store');
			Route::get('edit/{id}', 'edit')->name('tazkiia.communicate.edit');
			Route::put('{id}/update', 'update')->name('tazkiia.communicate.update');
			Route::get('delete/{id}', 'delete')->name('tazkiia.communicate.delete');
			Route::delete('destroy/{id}', 'destroy')->name('tazkiia.communicate.destroy');

		});



		Route::controller(LectureController::class)->prefix('tazkiia/lectures')->group(function () {
			Route::get('', 'index')->name('tazkiia.lectures.index');
			Route::get('create', 'create')->name('tazkiia.lectures.create');
			Route::post('store', 'store')->name('tazkiia.lectures.store');
			Route::get('edit/{id}', 'edit')->name('tazkiia.lectures.edit');
			Route::put('{id}/update', 'update')->name('tazkiia.lectures.update');
			Route::get('delete/{id}', 'delete')->name('tazkiia.lectures.delete');
			Route::delete('destroy/{id}', 'destroy')->name('tazkiia.lectures.destroy');
		});


		Route::controller(MartyrDocController::class)->prefix('tazkiia/martyr-documentions')->group(function () {
			Route::get('{martyr}', 'index')->name('tazkiia.martyrDocs.index');
			Route::get('{martyr}/create', 'create')->name('tazkiia.martyrDocs.create');
			Route::post('{martyr}/store', 'store')->name('tazkiia.martyrDocs.store');
			Route::get('edit/{id}', 'edit')->name('tazkiia.martyrDocs.edit');
			Route::put('{id}/update', 'update')->name('tazkiia.martyrDocs.update');
			Route::get('delete/{id}', 'delete')->name('tazkiia.martyrDocs.delete');
			Route::delete('destroy/{id}', 'destroy')->name('tazkiia.martyrDocs.destroy');
		});


		Route::get('tazkiia/martyrs-documention', 'TaskiiaController@martyrsDocsList')->name('tazkiia.martyrsDocsList');
		Route::get('tazkiia/hag-services', 'TaskiiaController@hagsMembersList')->name('tazkiia.hagsMembersList');
		Route::get('tazkiia/report', 'TaskiiaController@report')->name('tazkiia.report');

		Route::get('reports/gross', 'GrossController@gross')->name('reports.gross');



	Route::controller(ProfileController::class)->prefix('profile')->group(function () {
		Route::get('', 'profile')->name('profile');
		Route::put('update', 'update')->name('profile.update');
	});
	

	Route::controller(CourseController::class)->prefix('courses')->group(function () {
		Route::get('', 'index')->name('courses.index');
	});
	
	Route::controller(SettingController::class)->prefix('settings')->group(function () {
		Route::get('', 'settingPage')->name('settings.index')->can('admin-or-moderate');
		Route::post('backup', 'backup')->name('settings.backup')->can('admin-or-moderate');
		Route::get('/backup/download', 'downloadBackup')->name('settings.downloadBackup')->can('admin-or-moderate');
	});
	
	Route::post('/backup/restore', 'SettingController@importBackup')->name('backup.restore')->can('admin-or-moderate');
	
});