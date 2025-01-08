<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Tests\RequestMatcher\IsJsonRequestMatcherTest;
use Illuminate\Support\Str;
class APIController extends Controller
{
    public function getUsers($id=null)
    {
        if (empty($id)){
            $users = User::get();
        return response()->json(["users"=>$users],200); 
        }
        else{
           $users=User::find($id);
           return response()->json(["users"=>$users],200);
        } 

    }
    public function getUsersList(Request $request)
    {
        $header= $request->header('Authorization');
        if(empty($header)){
                $message="Header Authorization is missing!";
                return response()->json(['status'=>false,"message"=>$message],422);
        }
        else{
            if($header=="123456"){
                $users = User::get();
                return response()->json(["users"=>$users],200); 
            }
            else{

                $message="Header Authorization is missing!";

                return response()->json(['status'=>false,"message"=>$message],422);
            }           
        }
    }
    public function getCategories(){
        $categories=Category::get();
        return response()->json(["categories"=>$categories]);
    }

    public function addUsers(Request $request){

        if ($request->isMethod('post')){
            $userData=$request->input();

            // echo "<pre>"; print_r($userData);die;

            //SImple POST API validations 
            //Check user details

            // if(empty($userData['name'])||empty($userData['email'])||empty($userData['password']))
            // {
            //     $message= "Please enter complete user details!";
            //         return response()->json(["status"=>false,"message"=>$message],422);
            // }

            // //Check email validate
            // if(!filter_var($userData['email'],FILTER_VALIDATE_EMAIL)){
            //     $message= "Please enter valid Email!";
            //     return response()->json(["status"=>false,"message"=>$message],422);
            // }
            // // CHeck if User Email Already Exists

            // $userCount= User::where('email',$userData['email'])->count();

            // if($userCount>0){
            //     $message= "Email Already Exists!";
            //     return response()->json(["status"=>false,"message"=>$message],422);
            // }

            //Advance POST API VALidation 
                $rules=[
                        "name" => "required|regex:/^[\pL\s\-]+$/u",
                        "email" => "required|email|unique:users",
                        "password" => "required"
                ];

                $customMessage=[
                        'name.required' => 'Name is required',
                        'email.required' => 'Email is required',
                        'email.email' => 'Valid Email is required',
                        'email.unique' => 'Email already exists in databse',
                        'password.required' => 'Password is required'
                ];

               $validator= Validator::make($userData,$rules,  $customMessage);
               if($validator->fails()){
                return response()->json($validator->errors(),422);
               } 
            $user = new User;
            $user->name= $userData['name'];
            $user->email= $userData['email'];
            $user->password= bcrypt($userData['password']);
            $user->save();
            return response()->json(["message"=>'User added successfully!'],201);
        }
    }

    public function registerUser(Request $request){
                if($request->isMethod('post')){
                    $userData=$request->input();
                    // echo"<pre>"; print_r($userData);die;
                    $rules=[
                        "name" => "required|regex:/^[\pL\s\-]+$/u",
                        "email" => "required|email|unique:users",
                        "password" => "required"
                ];

                $customMessage=[
                        'name.required' => 'Name is required',
                        'email.required' => 'Email is required',
                        'email.email' => 'Valid Email is required',
                        'email.unique' => 'Email already exists in databse',
                        'password.required' => 'Password is required'
                ];

               $validator= Validator::make($userData,$rules,  $customMessage);
               if($validator->fails()){
                return response()->json($validator->errors(),422);
               } 

                    //Generate Unique Access Token

                    $apiToken = Str::random(60);

                    $user = new User;

                    $user->name=$userData['name'];
                    $user->email=$userData['email'];
                    $user->password=bcrypt($userData['password']);
                    $user->api_token=$apiToken;
                    $user->save();

                    return response()->json([
                        'status'=>true,
                        "message"=>"User registered successfully",
                        "token"=>$apiToken
                    ]
                        ,
                        201);

                }
    }
    public function addMultipleUsers(Request $request){

        if($request->isMethod('post')){
            $userData=$request->input();
            $rules = [
                "users.*.name"=>"required|regex:/^[\pL\s\-]+$/u",
                "users.*.email" => "required|unique:users",
                "users.*.password" => "required"
            ];
            $customMessage=[
                'users.*.name.required' => 'Name is required',
                'users.*.email.required' => 'Email is required',
                'users.*.email.email' => 'Valid Email is required',
                'users.*.email.unique' => 'Email already exists in databse',
                'users.*.password.required' => 'Password is required'
        ];
            // echo "<pre>"; print_r($userData);die;
            $validator= Validator::make($userData,$rules,$customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),422);
               } 

            foreach ($userData['users'] as $key => $value) {
                $user = new User;

                $user->name= $value['name'];
                $user->email= $value['email'];
                $user->password= bcrypt($value['password']);
                $user->save();
            }
            return response()->json(["message"=>'User added successfully!'],201);
        }
    }
        public function updateUserDetails(Request $request){

            if($request->isMethod('put')){
                    $userData=$request->input();
                     // echo "<pre>"; print_r($userData);die;
                     $rules=[
                        "name" => "required|regex:/^[\pL\s\-]+$/u",
                        "password" => "required"
                ];

                $customMessage=[
                        'name.required' => 'Name is required',
                        'password.required' => 'Password is required'
                ];
               $validator= Validator::make($userData,$rules,  $customMessage);
               if($validator->fails()){
                return response()->json($validator->errors(),422);
               } 

                    User::where('id',$userData['id'])->update(['name'=>$userData['name'],'password'=>bcrypt($userData['password'])]);

                    return response()->json(["message"=>"User Details Updated Successfully"],202);
            }
    }
    public function updateUserName(Request $request,$id){

        if ($request->isMethod('patch')){
            $userData=$request->input();
        }
        // echo"<pre>";print_r($userData);die;
        User::where('id',$id)->update(['name'=>$userData['name']]);

        return response()->json(['message'=>"User Detail Updated Successfully"],202);     
    }
    public function deleteUser($id){

        User::where('id',$id)->delete();
        return response()->json(["message"=>"User Deleted Successfully"],202);
    }
    public function deleteUserWithJson(Request $request){

        if($request->isMethod('delete')){
            $userData=$request->input();
        }
//   echo"<pre>";print_r($userData);die;

        User::where('id',$userData['id'])->delete();
        return response()->json(["message"=>"User Deleted Successfully!!"],202);
    }
    public function deleteMultipleUsers($ids){
        $ids = explode(",",$ids);
        //   echo"<pre>";print_r($ids);die;
        User::whereIn('id',$ids)->delete();
        return response()->json(["message"=>"Users Deleted Successfully!!"],202);
    }
    public function deleteMultipleUsersWithJson(Request $request){
        if($request->isMethod('delete')){
            $userData=$request->all();
        User::whereIn('id',$userData['ids'])->delete();
        return response()->json(["message"=>"Users Deleted Successfully!!"],202);
        }
    }
}

