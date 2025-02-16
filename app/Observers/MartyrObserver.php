<?php

namespace App\Observers;

use App\Models\Martyr;
use Illuminate\Support\Facades\Auth;

class MartyrObserver
{
    /**
     * Handle the Martyr "created" event.
     *
     * @param  \App\Models\Martyr  $martyr
     * @return void
     */
    public function creating(Martyr $martyr)
    {
       if (Auth::check()) {
           $martyr->user_id = Auth::id();
       }
    }

    /**
     * Handle the Martyr "updated" event.
     *
     * @param  \App\Models\Martyr  $martyr
     * @return void
     */
    public function updated()
    {
        cache()->clear();
    }

    /**
     * Handle the Martyr "deleted" event.
     *
     * @param  \App\Models\Martyr  $martyr
     * @return void
     */
    public function deleted(Martyr $martyr)
    {
        cache()->clear();
    }
}
