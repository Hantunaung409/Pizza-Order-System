<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //direct List Page
    public function list(){
        $order = Order::select('orders.*', 'users.name as user_name')
                        ->leftJoin('users','users.id','orders.user_id')
                        ->when(request('key'), function($query){
                            $query->where('users.name','like','%'.request('key').'%');
                        })
                        ->orderBy('id','desc')
                        ->paginate('5');
        $order->appends(request()->all());
        return view('admin.order.list',compact('order'));
    }

    //sort with order list ajax status
    public function sortWithStatus(Request $request){
        $order = Order::select('orders.*', 'users.name as user_name')
                        ->leftJoin('users','users.id','orders.user_id')
                        ->when(request('key'), function($query){
                           $query->where('users.name','like','%'.request('key').'%');
                        })
                        ->orderBy('id','desc');

         if ($request->status == null) {
            $order = $order->paginate('5');
         }else {
            $order = $order->where('orders.status', $request->status)->paginate('5');
         }

        $order->appends(request()->all());
        return view('admin.order.list',compact('order'));
    }

    //change order status with ajax
    public function changeStatus(Request $request){
        Order::where('id',$request->orderId)->update([
            'status' => $request->status
            ]);
    }

}
