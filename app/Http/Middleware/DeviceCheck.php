<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class DeviceCheck
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
        $rule = [
            'DeviceToken'=>'required',
            'DeviceType'=>'required|in:android,ios',
        ]; 
        $message = [
           // 'DeviceType.in'=>'DeviceType must be android or ios'
        ]; 
        $attribute=[
            'DeviceToken'=>'DeviceToken',
            'DeviceType'=>'DeviceType'
        ];      
        $validator = Validator::make($request->all(),$rule,$message,$attribute);
        if($validator->fails()){
            return response()->json(['message'=>$validator->errors()->first(),'status'=>400]);
        }
        return $next($request);
    }
}
