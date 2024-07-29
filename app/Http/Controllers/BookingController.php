<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Booking::all();
        if (!$data) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Bookings not found',
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
            'customer_id' => 'required|exists:customers,id',
            'meja_id' => 'required|exists:mejas,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'total_price' => 'required|numeric',
            'status' => 'required|string|in:booked,completed,canceled'
        ]);
        
        $data = new Booking();
        $data->customer_id = $request->input('customer_id');
        $data->meja_id = $request->input('meja_id');
        $data->start_time = $request->input('start_time');
        $data->end_time = $request->input('end_time');
        $data->total_price = $request->input('total_price');
        $data->status = $request->input('status');
        $data->save();

        Log::info('Adding Booking');

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
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Booking::find($id);
        if(!$data) {
            return response()->json([
                "success" => false,
                "message" => "Parameter Not Found"
            ]);
        }

        Log::info('Showing booking by id');

        return response()->json([
            "success" => true,
            "message" => "Success retrieve data",
            "data" => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'customer_id' => 'required|exists:customers,id',
            'meja_id' => 'required|exists:mejas,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'total_price' => 'required|numeric',
            'status' => 'required|string|in:booked,completed,canceled'
        ]);
        
        $data = Booking::find($id);
        if ($data) {
            $data->customer_id = $request->input('customer_id');
            $data->meja_id = $request->input('meja_id');
            $data->start_time = $request->input('start_time');
            $data->end_time = $request->input('end_time');
            $data->total_price = $request->input('total_price');
            $data->status = $request->input('status');
            $data->save();

            Log::info('Updating booking by id');

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
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Booking::find($id);
        if($data) {
            $data->delete();

            Log::info('Deleting booking by id');

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
