<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    //return pizza list
    public function pizzaList(Request $request){
        if($request->status == 'asc'){
         $data = Product::orderBy('id','asc')->get();

       }else{
         $data = Product::orderBy('id','desc')->get();
       }

        return response()->json($data, 200);
    }

    //add to cart
    public function addToCart(Request $request){
        $data = $this->getOrderData($request);

        Cart::create($data);

        $response = [
           'message' => 'Added to cart successfully' ,
           'status' => 'success'
        ];
        return response()->json($response,200);

    }

    //get order data
    private function getOrderData($request){
        return [
        'user_id' => $request->userId,
        'product_id' => $request->pizzaId,
        'qty' => $request->count,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
        ];
    }
}
