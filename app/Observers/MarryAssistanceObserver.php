<?php

namespace App\Observers;

use App\Models\MarryAssistance;

class MarryAssistanceObserver
{
    /**
     * Handle the MarryAssistance "created" event.
     *
     * @param  \App\Models\MarryAssistance  $marryAssistance
     * @return void
     */
    public function created(MarryAssistance $marryAssistance)
    {
        cache()->forget('member_profile_'.$marryAssistance->family_member_id);
    }

    /**
     * Handle the MarryAssistance "updated" event.
     *
     * @param  \App\Models\MarryAssistance  $marryAssistance
     * @return void
     */
    public function updated(MarryAssistance $marryAssistance)
    {
        cache()->forget('member_profile_'.$marryAssistance->family_member_id);
    }

    /**
     * Handle the MarryAssistance "deleted" event.
     *
     * @param  \App\Models\MarryAssistance  $marryAssistance
     * @return void
     */
    public function deleted(MarryAssistance $marryAssistance)
    {
        cache()->forget('member_profile_'.$marryAssistance->family_member_id);
    }
}
