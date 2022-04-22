<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Models\User;
use Response;

class AuthenticateApi
{
    /*
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::where('id', $request->user_id)->where('user_session_token', $request->header('token'))->first();
                                               
        if(!empty($user->id))
        {
			return $next($request);
        }
        else
        {
			return Response::json(['result' => 'failure' ,'message'=>'Login Expired'], 200);
        }
    }
}