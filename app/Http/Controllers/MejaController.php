<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MejaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Meja::all();
        if (!$data) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Mejas not found',
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
            'status' => 'required|string|in:available,occupied,maintenance'
        ]);
        
        $data = new Meja();
        $data->name = $request->input('name');
        $data->status = $request->input('status');
        $data->save();

        Log::info('Adding meja');

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
     * @param  \App\Models\Meja  $meja
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Meja::find($id);
        if(!$data) {
            return response()->json([
                "success" => false,
                "message" => "Parameter Not Found"
            ]);
        }

        Log::info('Showing meja by id');

        return response()->json([
            "success" => true,
            "message" => "Success retrieve data",
            "data" => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meja  $meja
     * @return \Illuminate\Http\Response
     */
    public function edit(Meja $meja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meja  $meja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:available,occupied,maintenance'
        ]);
        
        $data = Meja::find($id);
        if ($data) {
            $data->name = $request->input('name');
            $data->status = $request->input('status');
            $data->save();

            Log::info('Updating meja by id');

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
     * @param  \App\Models\Meja  $meja
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Meja::find($id);
        if($data) {
            $data->delete();

            Log::info('Deleting meja by id');

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
