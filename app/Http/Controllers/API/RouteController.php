<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    //get all product list
    public function productList(){
        $products = Product::get();
        $users = User::get();

        $data = [
            'product' => $products,
            'users' => $users
        ];
        return $data['product'][0]->name;
        //optional
        return response()->json($data, 200);
    }

    //get category list
    public function categoryList(){
        $category = Category::get();
        return response()->json($category, 200);
    }

    //category list using get with id in url
    public function categoryListUsingId($id){
        $data = Category::where('id',$id)->first();
        if (isset($data)) {
        return response()->json(['status' => true,'Category data' => $data], 200);
        }

        return response()->json(['status' => false,'message' => 'there is no category '], 404);

    }

    //create category
    public function createCategory(Request $request){
        $data = [
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        $response = Category::create($data);

       return response()->json($response, 200);
    }

    //create Contact
    public function createContact(Request $request){
        $data = [
           'name' => $request->name,
           'email' => $request->email,
           'message_code' => random_int('100000','999999'),
           'message' => $request->message,
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now()
        ];
        $response = Contact::create($data);
        return response()->json($response, 200);
    }

    //delete contact using post
    public function deleteContact(Request $request){
        $data = Contact::where('id',$request->id)->first();
        if (isset($data)) {
        Contact::where('id',$request->id)->delete();
        return response()->json(['status' => true,'message' => 'delete Success'], 200);
        }

        return response()->json(['status' => false,'message' => 'there is no id '], 200);

    }

        //delete contact using get
        public function deleteContactUsingGet($id){
            $data = Contact::where('id',$id)->first();
            if (isset($data)) {
            Contact::where('id',$id)->delete();
            return response()->json(['status' => true,'message' => 'delete Success'], 200);

            // you can temporarily store delete data inside return i.e. ['delete data' => $data] and $data should be catch before deleted
            }

            return response()->json(['status' => false,'message' => 'there is no id '], 200);

        }

        //category details using post
        public function categoryDetails(Request $request){
            $data = Category::where('id',$request->id)->first();
            if (isset($data)) {
            return response()->json(['status' => true,'Category data' => $data], 200);
            }

            return response()->json(['status' => false,'message' => 'there is no category '], 404);

        }

        //update category
        public function updateCategory(Request $request){
            $dbSource = Category::where('id',$request->id)->first();

            if(isset($dbSource)){
             $data = Category::where('id',$request->id)->update([
                'name' => $request->name,
                'updated_at' => Carbon::now()
            ]);
            $response = Category::where('id',$request->id)->first();
            return response()->json(['status' => true , 'message' => 'update success','updated Category' => $response], 200);
            }

            return response()->json(['status' => false , 'message' => 'No category match the id'], 500);

        }
}
