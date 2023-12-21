<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderDetailResource;

class OrderController extends Controller
{
    public function index(){
        $order = Order::all();
        return OrderDetailResource::collection($order->loadMissing(['product:id,name,price,stock','customer:id,name,phone']));
    }
    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required'
        ]);

        $request['customer_id'] = Auth::user()->id;
        $order = Order::create($request->all());

        return new OrderDetailResource($order->loadMissing(['product:id,name,price,stock','customer:id,name,phone']));

    }
    public function update(Request $request, $id) {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required'
        ]);

        $order = Order::findOrFail($id);
        $order->update($request->all());

        return new OrderDetailResource($order->loadMissing(['product:id,name,price,stock','customer:id,name,phone']));

    }
    public function destroy($id){
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['data berhasil dihapus']);
        // return new OrderDetailResource($order->loadMissing(['product:id,name,price,stock','customer:id,name,phone']));

    }
}
