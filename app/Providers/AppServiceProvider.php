<?php

namespace App\Providers;

use Illuminate\Support\Facades\{Gate, View};
use Illuminate\Support\ServiceProvider;
use App\Models\Martyr;
use App\Models\FamilyMember;
use App\Observers\MemberObserver;
use App\Models\Hag;
use App\Observers\HagObserver;
use App\Observers\MartyrObserver;
use App\Models\Family;
use App\Observers\FamilyObserver;
use App\Models\FamilyMemberDocument;
use App\Observers\MemberDocumentObserver;
use App\Models\MarryAssistance;
use App\Observers\MarryAssistanceObserver;
use App\Models\MedicalTreatment;
use App\Observers\MedicalTreatmentObserver;
use App\Models\Address;
use App\Observers\AddressObserver;
use App\Models\Student;
use App\Observers\StudentObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Gate::define('isModerate', fn ($user) => $user->role == 'moderate');
        Gate::define('admin-or-moderate', fn ($user) => $user->role == 'moderate' || $user->role == 'admin');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //ini_set('max_execution_time', 300);
        app()->setLocale('ar');
        View::share('app_name', trans('messages.app_name'));
        Martyr::observe(MartyrObserver::class);
        Family::observe(FamilyObserver::class);
        FamilyMember::observe(MemberObserver::class);
        Address::observe(AddressObserver::class);
        Hag::observe(HagObserver::class);
        MarryAssistance::observe(MarryAssistanceObserver::class);
        MedicalTreatment::observe(MedicalTreatmentObserver::class);
        FamilyMemberDocument::observe(MemberDocumentObserver::class);
        Student::observe(StudentObserver::class);
    }
}
