<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //direct pizza lists page
    public function list(){
        $pizzas = Product::select('products.*', 'categories.name as category_name')
                           ->when(request('key'),function($query){
                           $query->where('products.name','like','%'.request('key').'%');
                           })
                           ->leftJoin('categories', 'products.category_id', 'categories.id')
                           ->orderBy('products.created_at','desc')
                           ->paginate(4);
        $pizzas->appends(request()->all());
        return view('admin.product.pizzaList',compact('pizzas'));
    }

    //direct products create Page
    public function createPage(){
        $categories = Category::select('id','name')->get();
        return view('admin.product.createPage',compact('categories'));
    }

    //products creating
    public function create(Request $request){
     $this->productValidation($request,"create");
     $data = $this->requestProductData($request);
     //for image
     if($request->hasFile('image')){
        $fileName = uniqid().$request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/productsImage', $fileName);
        $data['image'] = $fileName;
     }

     Product::create($data);
     return redirect()->route('products@list');
    }

    //products deleting
    public function delete($id){
        Product::where('id',$id)->delete();
        return redirect()->route('products@list')->with(['productDelete' => 'Deleted Successfully!']);
    }


    //direct products Details Page
    public function details($id){
        $pizza = Product::select('products.*', 'categories.name as category_name')
                       ->leftJoin('categories', 'products.category_id', 'categories.id')
                       ->where('products.id',$id)->first();
        return view('admin.product.details',compact('pizza'));
    }


    //direct products edit Page
    public function editPage($id){
        $pizzas = Product::where('id', $id)->first();
        $categories = Category::get();
        return view('admin.product.editPage',compact('pizzas','categories'));
    }

    //products edit
    public function edit($id,Request $request){
        $this->productValidation($request,"edit");
        $data = $this->requestProductData($request);
         //for image
       if($request->hasFile('image')){
        $oldImageName = Product::where('id',$id)->first();
        $oldImageName = $oldImageName->image;
         if($oldImageName != null ){
          Storage::delete('storage/productsImage/'.$oldImageName);
    }
        $fileName = uniqid().$request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/productsImage', $fileName);
        $data['image'] = $fileName;
     }
     Product::where('id',$id)->update($data);
     return redirect()->route('products@list');
    }






    //products creating validation check
    private function productValidation($request,$action){
        $validationRules = [
            'name' => 'required|unique:products,name,'.$request->pizzaID,
            'desc' => 'required',
            'price' => 'required|numeric|between:10000,40000',
            'waitingTime' => 'required'
        ];
        $validationRules['image'] = $action == "create" ? 'required|mimes:png,jpg,jpeg,webp|file' : "" ;
        $validationRules['categoryName'] = $action == "create" ? 'required' : "" ;
        Validator::make($request->all(),$validationRules)->validate();
    }

    //requesting products data
    private function requestProductData($request){
        return [
       'name' => $request->name,
       'category_id' => $request->categoryName,
       'description' => $request->desc,
       'price' => $request->price,
       'waiting_time' => $request->waitingTime
        ];
    }
}
