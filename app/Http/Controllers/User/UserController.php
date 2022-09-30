<?php

namespace App\Http\Controllers\User;

use Storage;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\MessageStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //direct user home page

    public function home(){
        $pizzas = Product::orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizzas','category','cart','history'));
    }

    //direct user password changing page
    public function changePasswordPage(){
        return view('user.account.change');
    }

    //changing password
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

    //account profile changingPage
    public function changeProfilePage(){
        return view('user.account.profile');
    }
    //account profile changing
    public function changeProfile($id, Request $request){
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

        return redirect()->route('user@changeProfilePage')->with(['updateSuccess' => 'admin account updated successfully']);
    }

    //filter by category
    public function filter($categoryId){
        $pizzas = Product::where('category_id',$categoryId)->orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizzas','category','cart','history'));
    }

    //direct pizza details page
    public function pizzaDetails($id){
        $pizza = Product::where('id',$id)->first();
        $pizzaList = Product::get();
        return view('user.main.detail',compact('pizza','pizzaList'));
    }

    //direct cart list page
    public function cartList(){
        $cartList = Cart::select('carts.*','products.name as productName','products.price as productPrice','products.image as product_image')
                      ->leftJoin('products','products.id','carts.product_id')
                      ->where('carts.user_id',Auth::user()->id)
                      ->get();

        $totalPrice = 0;
        foreach($cartList as $c){
           $totalPrice += $c->productPrice*$c->qty;
        }
        return view('user.main.cart',compact('cartList','totalPrice'));
    }

    //direct history page
    public function history(){
        $order = Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate('6');
        return view('user.main.history',compact('order'));
    }

    //direct contact page
    public function contactPage(){
        return view('user.contact.contactPage');
    }

    //contact data
    public function contactData(Request $request){
        $userName = User::where('id',$request->userId)->first();
        $this->sendMessageValidation($request);
        $data = Contact::create([
            'name' => $userName->name,
            'email' => $request->email,
            'message' => $request->message,
            'message_code' => random_int('100000','999999')
        ]);
        MessageStatus::create([
            'name' => $userName->name,
            'message_code' => $data->message_code
        ]);
        return redirect()->route('user@contactPage')->with(['Success' => 'The Message Was Sent!']);
    }




        // password changing validation
        private function changePasswordValidation($request){
            Validator::make($request->all(),[
                'oldPassword' => 'required',
                'newPassword' => 'required|min:6',
                'confirmPassword' => 'required|min:6|same:newPassword'

            ])->validate();
        }


        //account changing validation
    private function validationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp|file'
        ])->validate();
    }

        //request account edited data
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

    //Sent message validation
    private function sendMessageValidation($request){
        Validator::make($request->all(),[
            'email' => 'required',
            'message' => 'required'
        ])->validate();
    }


}
