<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Customer::all();
        if (!$data) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Customers not found',
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
            'full_name' => 'required|string|max:255',
            'username' => 'required',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone_number' => 'required'
        ]);
        
        $data = new Customer();
        $data->full_name = $request->input('full_name');
        $data->username = $request->input('username');
        $data->email = $request->input('email');
        $data->phone_number = $request->input('phone_number');
        $data->save();

        Log::info('Adding Customer');

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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Customer::find($id);
        if(!$data) {
            return response()->json([
                "success" => false,
                "message" => "Parameter Not Found"
            ]);
        }

        Log::info('Showing customer by id');

        return response()->json([
            "success" => true,
            "message" => "Success retrieve data",
            "data" => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'full_name' => 'required|string|max:255',
            'username' => 'required',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone_number' => 'required'
        ]);
        
        $data = Customer::find($id);
        if ($data) {
            $data->full_name = $request->input('full_name');
            $data->username = $request->input('username');
            $data->email = $request->input('email');
            $data->phone_number = $request->input('phone_number');
            $data->save();

            Log::info('Updating customer by id');

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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Customer::find($id);
        if($data) {
            $data->delete();

            Log::info('Deleting customer by id');

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
