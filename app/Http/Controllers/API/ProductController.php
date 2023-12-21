<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductDetailResource;
use Illuminate\Validation\ValidationException;


class ProductController extends Controller
{
    public function index() {
        $products =  Product::all();
        return ProductDetailResource::collection($products->loadMissing(['seller:id,name,email', 'orders:id,product_id,customer_id,quantity']));

        
    }
    public function show($id) {
        $product = Product::findOrFail($id);
        return new ProductDetailResource($product->loadMissing(['seller:id,name,email', 'orders:id,product_id,customer_id,quantity']));
    }
    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ]);

        $request['user_id'] = Auth::user()->id;
        $product = Product::create($request->all());
        return new ProductDetailResource($product->loadMissing(['seller:id,name,email', 'orders:id,product_id,customer_id,quantity']));

    }
    public function update(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ]);

        // $request['user_id'] = Auth::user()->id;
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return new ProductDetailResource($product->loadMissing(['seller:id,name,email', 'orders:id,product_id,customer_id,quantity']));

    }

    public function destroy($id) {
        $product = Product::findOrfail($id);
        $product->delete();

        return new ProductDetailResource($product->loadMissing(['seller:id,name,email', 'orders:id,product_id,customer_id,quantity']));
    }
}
