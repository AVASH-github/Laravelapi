<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
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

}
