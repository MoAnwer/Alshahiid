<?php

namespace App\Observers;

use App\Models\Hag;

class HagObserver
{
    /**
     * Handle the Hag "created" event.
     *
     * @param  \App\Models\Hag  $hag
     * @return void
     */
    public function created(Hag $hag)
    {
        cache()->forget('member_profile_'.$hag->family_member_id);
    }

    /**
     * Handle the Hag "updated" event.
     *
     * @param  \App\Models\Hag  $hag
     * @return void
     */
    public function updated(Hag $hag)
    {
        cache()->forget('member_profile_'.$hag->family_member_id);
    }

    /**
     * Handle the Hag "deleted" event.
     *
     * @param  \App\Models\Hag  $hag
     * @return void
     */
    public function deleted(Hag $hag)
    {
        cache()->forget('member_profile_'.$hag->family_member_id);
    }

    /**
     * Handle the Hag "restored" event.
     *
     * @param  \App\Models\Hag  $hag
     * @return void
     */
    public function restored(Hag $hag)
    {
        cache()->forget('member_profile_'.$hag->family_member_id);
    }

    /**
     * Handle the Hag "force deleted" event.
     *
     * @param  \App\Models\Hag  $hag
     * @return void
     */
    public function forceDeleted(Hag $hag)
    {
        cache()->forget('member_profile_'.$hag->family_member_id);
    }
}
