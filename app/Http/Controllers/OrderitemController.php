<?php

namespace App\Http\Controllers;

use App\Models\Orderitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Orderitem::with('order', 'product')->get();

        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Order items not found',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success retrieved data',
            'data' => $data,
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
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $data = new Orderitem();
        $data->product_id = $request->input('product_id');
        $data->order_id = $request->input('order_id');
        $data->quantity = $request->input('quantity');
        $data->save();

        Log::info('Order item added');

        return response()->json([
            'success' => true,
            'message' => 'Successfully added order item',
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Orderitem  $orderitem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Orderitem::with('order', 'product')->find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Order item not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success retrieved data',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Orderitem  $orderitem
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
     * @param  \App\Models\Orderitem  $orderitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $orderItem = Orderitem::find($id);
        if ($orderItem) {
            $orderItem->order_id = $request->input('order_id');
            $orderItem->product_id = $request->input('product_id');
            $orderItem->quantity = $request->input('quantity');
            $orderItem->save();
            Log::info('Updating order item by id', ['order_item_id' => $id]);

            return response()->json([
                "success" => true,
                "message" => "Success Updated",
                "data" => [
                    "attributes" => $orderItem
                ]
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Order Item Not Found"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orderitem  $orderitem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Orderitem::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Order item not found',
            ], 404);
        }

        $data->delete();

        Log::info('Order item deleted');

        return response()->json([
            'success' => true,
            'message' => 'Successfully deleted order item',
        ]);
    }
}
