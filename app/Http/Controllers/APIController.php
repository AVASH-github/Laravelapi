<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
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

            if(empty($userData['name'])||empty($userData['email'])||empty($userData['password']))
            {
                $message= "Please enter complete user details!";
                    return response()->json(["status"=>false,"message"=>$message],422);
            }

            //Check email validate
            if(!filter_var($userData['email'],FILTER_VALIDATE_EMAIL)){
                $message= "Please enter valid Email!";
                return response()->json(["status"=>false,"message"=>$message],422);
            }
            // CHeck if User Email Already Exists

            $userCount= User::where('email',$userData['email'])->count();

            if($userCount>0){
                $message= "Email Already Exists!";
                return response()->json(["status"=>false,"message"=>$message],422);
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

            // echo "<pre>"; print_r($userData);die;
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

}
