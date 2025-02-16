<?php

namespace App\Observers;

use App\Models\FamilyMemberDocument;

class MemberDocumentObserver
{
    /**
     * Handle the FamilyMemberDocument "created" event.
     *
     * @param  \App\Models\FamilyMemberDocument  $familyMemberDocument
     * @return void
     */
    public function created(FamilyMemberDocument $familyMemberDocument)
    {
        cache()->forget('member_profile_'.$familyMemberDocument->family_member_id);
    }

    /**
     * Handle the FamilyMemberDocument "updated" event.
     *
     * @param  \App\Models\FamilyMemberDocument  $familyMemberDocument
     * @return void
     */
    public function updated(FamilyMemberDocument $familyMemberDocument)
    {
        cache()->forget('member_profile_'.$familyMemberDocument->family_member_id);
    }

    /**
     * Handle the FamilyMemberDocument "deleted" event.
     *
     * @param  \App\Models\FamilyMemberDocument  $familyMemberDocument
     * @return void
     */
    public function deleted(FamilyMemberDocument $familyMemberDocument)
    {
        if(!is_null($familyMemberDocument->storage_path)) {
            @unlink('uploads/members_documents/'.$familyMemberDocument->storage_path);
        }

        cache()->forget('member_profile_'.$familyMemberDocument->family_member_id);
    }

}
