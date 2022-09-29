<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    //order
    public function order(Request $request){
        $total = 0;
        foreach ($request->all() as $item) {
           $data = OrderList::create([
             'user_id' => $item['user_id'],
             'product_id' => $item['product_id'],
             'qty' => $item['qty'],
             'total' => $item['total'],
             'order_code' => $item['order_code'],
            ]);
            $total += $data->total;
        }
        Cart::where('user_id',Auth::user()->id)->delete();

        Order::create([
           'user_id' => Auth::user()->id,
           'order_code' => $data->order_code,
           'total_price' => $total + 5000
        ]);

        return response()->json([
            'status' => 'true'
        ],200);
    }

    //clear cart
    public function clearCart(){
        Cart::where('user_id',Auth::user()->id)->delete();
    }

    //clear Row
    public function clearRow(Request $request){
        Cart::where('user_id',Auth::user()->id)
             ->where('id', $request->orderId)
             ->where('product_id', $request->productId)
             ->delete();
    }

    //change Admin Role
    public function changeRole(Request $request){
           User::where('id',$request->adminId)->update([
             'role' => $request->changeRole
             ]);
    }

    //increasing view count
    public function increaseViewCount(Request $request){
        $pizza = Product::where('id',$request->pizzaId)->first();
        Product::where('id',$request->pizzaId)->update([
            'view_count' => $pizza->view_count + 1
        ]);
    }

}
