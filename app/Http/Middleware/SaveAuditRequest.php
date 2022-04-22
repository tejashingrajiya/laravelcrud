<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Closure;

class SaveAuditRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request,  $response)
    {
        $input['user_id'] = $request->user_id;
        $input['api_name'] =Request::path(); 
        $input['request_json'] =  json_encode($request->all());
        $input['response_json'] =  $response->getContent();
        $input['created_at'] = date("Y-m-d H:i:s");
        $input['time_taken'] = round(microtime(true) * 1000);
        
        $test = \App\Models\Api_audit::create($input);
    }
}
