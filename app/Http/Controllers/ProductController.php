<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::all();
        if (!$data) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Products not found',
                ]
            );
        }else {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Successfully retrieved data',
                    'data' => $data,
                ]
            );
        }
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category' => 'required|string|in:makanan,minuman'
        ]);
        
        $data = new Product();
        $data->name = $request->input('name');
        $data->description = $request->input('description');
        $data->price = $request->input('price');
        $data->stock = $request->input('stock');
        $data->category = $request->input('category');
        $data->save();

        Log::info('Adding product');

        return response()->json([
            "success" => true,
            "message" => "Success Added",
            "data" => [
                "attributes" => $data
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Product::find($id);
        if(!$data) {
            return response()->json([
                "success" => false,
                "message" => "Parameter Not Found"
            ]);
        }

        Log::info('Showing product by id');

        return response()->json([
            "success" => true,
            "message" => "Success retrieve data",
            "data" => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category' => 'required|string|in:makanan,minuman'
        ]);
        
        $data = Product::find($id);
        if ($data) {
            $data->name = $request->input('name');
            $data->description = $request->input('description');
            $data->price = $request->input('price');
            $data->stock = $request->input('stock');
            $data->category = $request->input('category');
            $data->save();

            Log::info('Updating product by id');

            return response()->json([
                "success" => true,
                "message" => "Success Updated",
                "data" => [
                    "attributes" => $data
                ]
            ]);        
        }else {
            return response()->json([
                "success" => false,
                "message" => "Parameter Not Found"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::find($id);
        if($data) {
            $data->delete();

            Log::info('Deleting product by id');

            return response()->json([
                "success" => true,
                "message" => "Success Deleted",
                "data" => [
                    "attributes" => $data
                ]
            ]);   
        }else {
            return response()->json([
                "success" => false,
                "message" => "Parameter Not Found"
            ]);
        }
    }
}
