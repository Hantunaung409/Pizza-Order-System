<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminSideUserController extends Controller
{
    //
    public function list(){
        $users = User::where('role','user')->paginate('5');

        return view('admin.user.list',compact('users'));
    }
    //change user Role with ajax
    public function changeRole(Request $request){
      User::where('id',$request->userId)->update([
        'role' => $request->changeRole
      ]);
    }


    //delete user account
    public function deleteUser($id){
            User::where('id',$id)->delete();
            $users = User::where('role','user')->paginate('5');
            return view('admin.user.list',compact('users'))->with(['accountDeleted' => 'An admin Account was deleted!']);
    }
}
