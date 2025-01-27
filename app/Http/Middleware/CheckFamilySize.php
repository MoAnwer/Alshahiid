<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Family;

class CheckFamilySize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $family = Family::find($request->family);

        if($family->loadMissing('familyMembers')->familyMembers->count() >= $family->family_size) {
            return to_route('families.show', $family->id)->with('success', 'تم اضافة كل افراد الاسرة بنجاح');
        }

        return $next($request);
    }
}
