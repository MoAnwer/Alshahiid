<?php

namespace App\Observers;

use App\Models\MedicalTreatment;

class MedicalTreatmentObserver
{
    /**
     * Handle the MedicalTreatment "created" event.
     *
     * @param  \App\Models\MedicalTreatment  $medicalTreatment
     * @return void
     */
    public function created(MedicalTreatment $medicalTreatment)
    {
        cache()->forget('member_profile_'.$medicalTreatment->family_member_id);
    }

    /**
     * Handle the MedicalTreatment "updated" event.
     *
     * @param  \App\Models\MedicalTreatment  $medicalTreatment
     * @return void
     */
    public function updated(MedicalTreatment $medicalTreatment)
    {
        cache()->forget('member_profile_'.$medicalTreatment->family_member_id);
    }

    /**
     * Handle the MedicalTreatment "deleted" event.
     *
     * @param  \App\Models\MedicalTreatment  $medicalTreatment
     * @return void
     */
    public function deleted(MedicalTreatment $medicalTreatment)
    {
        cache()->forget('member_profile_'.$medicalTreatment->family_member_id);
    }

    /**
     * Handle the MedicalTreatment "restored" event.
     *
     * @param  \App\Models\MedicalTreatment  $medicalTreatment
     * @return void
     */
    public function restored(MedicalTreatment $medicalTreatment)
    {
        cache()->forget('member_profile_'.$medicalTreatment->family_member_id);
    }

    /**
     * Handle the MedicalTreatment "force deleted" event.
     *
     * @param  \App\Models\MedicalTreatment  $medicalTreatment
     * @return void
     */
    public function forceDeleted(MedicalTreatment $medicalTreatment)
    {
        cache()->forget('member_profile_'.$medicalTreatment->family_member_id);
    }
}
