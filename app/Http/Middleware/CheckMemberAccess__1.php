<?php

namespace App\Http\Middleware;

use App\Models\VotingForm;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMemberAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = Auth::id();
        $votFormId = $request->route('id');
        $votingForm = VotingForm::where('id',$votFormId)->whereHas('memberVotes',function($query) use ($userId) {
            $query->where('user_id',$userId);
        })->first();
        if(!$votingForm){
            return redirect()->route('member.home')->with('error','لا تملك صلاحية الوصول لهذه الصفحة');
        }
        return $next($request);
    }
}
