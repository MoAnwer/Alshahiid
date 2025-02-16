<?php

namespace App\Observers;

use App\Models\Family;

class FamilyObserver
{
    /**
     * Handle the Family "creating" event.
     *
     * @param  \App\Models\Family  $family
     * @return void
     */
    public function creating(Family $family)
    {
        // cache()->forget('family_record_'.$family->id);
        if (auth()->check()) {
           $family->user_id = auth()->id();
        }
    }

    /**
     * Handle the Family "updated" event.
     *
     * @param  \App\Models\Family  $family
     * @return void
     */
    public function updated(Family $family)
    {
        cache()->forget('family_record_'.$family->id);
    }

    /**
     * Handle the Family "deleted" event.
     *
     * @param  \App\Models\Family  $family
     * @return void
     */
    public function deleted(Family $family)
    {
        cache()->forget('family_record_'.$family->id);
    }
}
