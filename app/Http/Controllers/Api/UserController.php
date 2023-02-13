<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\textModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($flag)
    {
        //
        // p("Get Api is Working");
        $users = User::all();
        if($flag == 0){
            $users = User::all();
            // $query->where('status',0);
        }else if($flag == 1){
            // $users = User::all();
            $users->where('id',1);

        }else{
            return response()->json([
                'message' => 'invaild parameter passed :)',
                'status' => 0
            ],400);
        }
        // $users = $query->get();
        if(count($users) > 0){
            $response = [
                'message' => count($users) . ' users found ',
                'status' => 1,
                'data' => $users
            ];
            return response()->json($response,200);
        }else{
            $response = [
                'message' => count($users) . ' users found ',
                'status' => 0,
            ];
            return response()->json($response,200);

        }
    }

    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all() ,[
        'name' => ['required'],
        'email' => ['required' ,'email' ,'unique:users,email'],
        'password' => ['required','min:8','confirmed'],
        'password_confirmation' => ['required']
        // its a kind of server side validation
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
            // 400 for bad request s
        }else{
            // if the validator is ture then we have to add the user
            // p($request->all());
            $data=[
                    'name' => $request->name,
                    'email' => $request->email,
                    // 'password' => Hash::make($request->password)
                    'password' => $request->password
                ];
                // p("Data After hashing the password");
                // p($data);s
            DB::beginTransaction();
            try{
            User::create($data);
            DB::commit();
            }catch(\Exception $e){
                DB::rollBack();
                p($e);
            }
    }

    // $token = $data::createToken("auth_token")->accessToken;
    // return response()->json([
    //     'token' => $token,
    //     'user' => $user,
    //     'message' => "User Created Successfully",
    //     'status' => 1
    // ],200);

    // p($request->all());
    }

   
    public function show($id)
    {
        //
        // $user = User::find($id);
        $user = User::all();
        if(is_null($user)){
            $response=[
                'message'=> 'user not found',
                'status'=> 0,
            ];
        }else{
            $response =[
                'message'=> 'user found',
            'status'=> 1,
            'data' => $user
            ];
        }
        return $reponse()->json($response,200);
    }

    
    public function edit($id)
    {
        //
    }

  
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id);
        if(is_null($user)){
            // user dosen't exist 
            return response()->json([
                'status' => 0,
                'message' => "user dosen't exist "
            ],404);
        }else{
            DB::beginTransaction();
            try{
            $user->name = $request['name'];
            $user->email = $request['email'];
            // $user->password = $request['password'];
            $user->save();
            DB::commit();
            }catch(\Exception $err){
                DB::rollBack();
                $user = null;
            }

            if(is_null($user)){
                return response()->json([
                    'message' => "Internal server error",
                    'status' => 0,
                    'error_msg' => $err->getMessage()
                ],500); 
            }else{
                return response()->json([
                    'status' => 1,
                    'message' => "USer data updated successfully"
                ],200);
            }

        }
    }

    public function destroy($id)
    {
       $user = User::find($id);
       if(is_null($user)){
        $response = [
            'message' => "User Dosen't exist",
            'status' => 0
        ];
        $respocode = 404;
       }else{
        DB::beginTransaction();
        try{
            $user->delete();
            DB::commit();
            $response =[
                'message' => "User Deleted Successfully",
                'status' => 1
            ];
            $respocode = 200;
        }catch(\Exception $err){
            DB::rollBack();
             $response =[
                'message' => "Internal Server code",
                'status' => 0
            ];
            $respocode = 500;
        }
       }
       return response()->json($response,$respocode);
    }

    public function changePassword(Request $request , $id){
        $user = User::find($id);
        if(is_null($user)){
            return response()->json([
                'status' => 0,
                'message' => 'User does not exist'
            ],404);
        }else{
            // change password
            if($user->password == $request['old_password']){
                // change karna hai
                if($request['new_password'] == $request['confirm_password']){
                DB::beginTransaction();
                    try{
                        $user->password = $request['confirm_password'];
                        $user->save();
                        DB::commit();
                    }catch(\Exception $err){
                        $user = null;
                        DB::rollBack();
                        
                    }
                    if(is_null($user)){
                return response()->json([
                    'message' => "Internal server error",
                    'status' => 0,
                    'error_msg' => $err->getMessage()
                ],500); 
            }else{
                return response()->json([
                    'status' => 1,
                    'message' => "Password updated successfully"
                ],200);
            }
                }else{
                   return response()->json([
                    'status' => 0,
                    'message' => "new password and confirm password doesn't match"
                ],400); 
                }
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => "old password doesn't match"
                ],400);
            }
        }
    }
}
