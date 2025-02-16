<?php

namespace App\Observers;

use App\Models\FamilyMember;

class MemberObserver
{
    /**
     * Handle the FamilyMember "created" event.
     *
     * @param  \App\Models\FamilyMember  $familyMember
     * @return void
     */
    public function created(FamilyMember $familyMember)
    {
       cache()->forget('family_record_'.$familyMember->family_id);
    }

    /**
     * Handle the FamilyMember "updated" event.
     *
     * @param  \App\Models\FamilyMember  $familyMember
     * @return void
     */
    public function updated(FamilyMember $familyMember)
    {
       cache()->forget('family_record_'.$familyMember->family_id);
    }

    /**
     * Handle the FamilyMember "deleted" event.
     *
     * @param  \App\Models\FamilyMember  $familyMember
     * @return void
     */
    public function deleted(FamilyMember $familyMember)
    {
        if ($familyMember->personal_image) {
            @unlink('uploads/images/'.$familyMember->personal_image);
        }

        if(isset($familyMember->documents)) {

            foreach($familyMember->documents as $doc) 
            {
                if (empty($doc->storage_path)) {
                    @unlink('uploads/members_documents/'.$doc->storage_path);
                }
            }

        }

        cache()->forget('family_record_'.$familyMember->family_id);
    }

}
