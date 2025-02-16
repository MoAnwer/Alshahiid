<?php

namespace App\Observers;

use App\Models\MartyrDoc;

class MartyrDocObserver
{
    /**
     * Handle the MartyrDoc "deleted" event.
     *
     * @param  \App\Models\MartyrDoc  $martyrDoc
     * @return void
     */
    public function deleted(MartyrDoc $martyrDoc)
    {
        @unlink('uploads/documents/'.$martyrDoc->storage_path);
    }
}
