<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('user::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //get staff details
        //todo staff table needed
        $res = $this->staffCreateValidation($request);
        if($res!==true){
            //if validation not true then return response json 
            return $res;
        }
        $data = array(
            ''
        );
        
        print_r('tesdfjklsdjkla');exit;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function staffCreateValidation($request){
        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'string',
            'email'=>'required|email|unique:users,Email',
            'phone'=>'required|digits:10|unique:users,Phone',
            'staff_role' => 'required|string|in:'.implode(',', array_keys(config('user.const.roles_staff'))),            
        ];
        $validator = Validator::make($request->all(), $rules);        
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => 400]);
        }
        return true;
    }
}
