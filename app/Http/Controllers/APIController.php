<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class APIController extends Controller
{
    public function getUsers($id=null)
    {
        if (empty($id)){
            $users = User::get();
        return response()->json(["users"=>$users]); 
        }
        else{
           $users=User::find($id);
           return response()->json(["users"=>$users]);
        } 

    }
}
