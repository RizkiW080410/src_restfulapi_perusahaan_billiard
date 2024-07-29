<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Orderitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Order::with('items')->get();

        if ($data->isEmpty()) {
            return response()->json([
                "success" => false,
                "message" => "Data Not Found"
            ]);
        }

        Log::info('Showing all orders');

        return response()->json([
            "success" => true,
            "message" => "Success retrieve data",
            "data" => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required|exists:customers,id',
            'order_detail' => 'required|array'
        ]);

        $order = new Order();
        $order->customer_id = $request->input('customer_id');
        $order->status = "pending";
        $order->total_price = 0;
        $order->save();

        $orderItems = [];
        $totalPrice = 0;
        foreach ($request->input('order_detail') as $item) {
            $orderItem = new Orderitem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item['product_id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->save();
            $orderItems[] = $orderItem;
            $totalPrice += $orderItem->product->price * $orderItem->quantity;
        }

        $order->total_price = $totalPrice;
        $order->save();

        Log::info('Adding order');

        return response()->json([
            "message" => "Success Added",
            "status" => true,
            "data" => $order
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Order::with('items')->find($id);

        if (!$data) {
            return response()->json([
                "message" => "Parameter Not Found"
            ]);
        }

        Log::info('Showing order by id');

        return response()->json([
            "message" => "Success retrieve data",
            "status" => true,
            "data" => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'customer_id' => 'required|exists:customers,id',
            'order_detail' => 'required|array'
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                "message" => "Parameter Not Found"
            ]);
        }

        $order->customer_id = $request->input('customer_id');
        $order->status = "pending";
        $order->total_price = 0;
        $order->save();

        Orderitem::where('order_id', $order->id)->delete();

        $orderItems = [];
        $totalPrice = 0;
        foreach ($request->input('order_detail') as $item) {
            $orderItem = new Orderitem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item['product_id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->save();
            $orderItems[] = $orderItem;
            $totalPrice += $orderItem->product->price * $orderItem->quantity;
        }

        $order->total_price = $totalPrice;
        $order->save();

        Log::info('Updating order by id');

        return response()->json([
            "message" => "Success Updated",
            "status" => true,
            "data" => $order
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                "message" => "Parameter Not Found"
            ]);
        }

        Orderitem::where('order_id', $order->id)->delete();
        $order->delete();

        Log::info('Deleting order by id');

        return response()->json([
            "message" => "Success Deleted",
            "status" => true,
            "data" => $order
        ]);
    }
}
