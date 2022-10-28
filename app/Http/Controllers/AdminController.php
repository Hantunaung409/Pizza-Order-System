<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //direct change password page
    public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    //change admin password
    public function changePassword(Request $request){
        $this->changePasswordValidation($request);

        $user = \App\Models\User::select('password')->where('id', Auth::user()->id)->first();

        $dbHashedPassword = $user->password;

        if(Hash::check($request->oldPassword, $dbHashedPassword)){
           User::where('id',Auth::user()->id)->update([
              'password' => Hash::make($request->newPassword)
           ]);
           Auth::logout();
           return redirect()->route('auth@loginPage');
        }
        return back()->with(['notMatch' => ' The Old Password is wrong!']);

    }

    //direct account details
    public function details(){
        return view('admin.account.details');
    }

    //direct edit details page
    public function editDetailsPage(){
        return view('admin.account.editDetails');
    }


    //update edited details
    public function updateDetails($id,Request $request){
        $this->validationCheck($request);
        $data = $this->requestData($request);

        //for image
        if($request->hasFile('image') ){
          $dbImage = User::where('id',$id)->first();
          $dbImage = $dbImage->image;
          if($dbImage != null){
            Storage::delete('public/'.$dbImage);
          }
          $fileName = uniqid(). $request->image->getClientOriginalName();
          $request->file('image')->storeAs('public',$fileName);
          $data['image'] = $fileName;
        }

        User::where('id',$id)->update($data);

        return redirect()->route('admin@details')->with(['updateSuccess' => 'admin account updated successfully']);
    }
   //direct admin lists
        public function listPage(){
            $adminList = User::when(request('key'),function ($query){
                                $query->orWhere('name','like','%'.request('key').'%')->where('role','admin')
                                      ->orWhere('email','like','%'.request('key').'%')->where('role','admin')
                                      ->orWhere('gender','like','%'.request('key').'%')->where('role','admin')
                                      ->orWhere('phone','like','%'.request('key').'%')->where('role','admin')
                                      ->orWhere('address','like','%'.request('key').'%')->where('role','admin');
                               })
                               ->where('role','admin')
                               ->paginate(4);
            return view('admin.account.list',compact('adminList'));
        }

    //delete account
    public function delete($id){
        User::where('id',$id)->delete();
        return view('admin.account.list')->with(['accountDeleted' => 'An admin Account was deleted!']);
    }

    // //direct change role page
    // public function changeRolePage($id){
    //     $account = User::where('id',$id)->first();
    //     return view('admin.account.changeRole',compact('account'));
    // }

    // //change role
    // public function changeRole($id, Request $request){
    //     $data = $this->requestChangeRoleData($request);
    //     User::where('id',$id)->update($data);
    //     return redirect()->route('admin@listPage');
    // }





    //requesting data of changing role
    private function requestChangeRoleData($request){
        return [
            'role' => $request->role
        ];
    }
    //request edited data
    private function requestData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'updated_at' => Carbon::now()
        ];
    }

    // password changing validation
    private function changePasswordValidation($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword'

        ])->validate();
    }

    //editing validation
    private function validationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp|file'
        ])->validate();
    }
}
