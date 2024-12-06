<?php

namespace App\Http\Controllers\Api;

use App\Models\Makul;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MakulResource;
use Illuminate\Support\Facades\Validator;

class MakulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $makul = Makul::latest()->get();
        return response()->json([
            'data' => MakulResource::collection($makul),
            'message' => 'Fetch All Makul',
            'success' => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            'nama_makul'  => 'required|string|max:255',
            'sks'   => 'required|numeric|max:11',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data'      => [],
                'message'   => $validator->errors(),
                'success'   => false
            ]);
        }
        $makul = Makul::create([
            'nama_makul'  => $request->get('nama_makul'),
            'sks'   => $request->get('sks'),
        ]);
        return response()->json([
            'data' => new MakulResource($makul),
            'message' => 'Data Makul Created Successfully',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Makul $makul)
    {
        return response()->json([
            'data' => new MakulResource($makul),
            'message' => 'Data Makul Found',
            'success' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Makul $makul)
    {
        $validator  = Validator::make($request->all(), [
            'nama_makul'  => 'required|string|max:255',
            'sks'   => 'required|numeric|max:11',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data'      => [],
                'message'   => $validator->errors(),
                'success'   => false
            ]);
        }
        $makul->update([
            'nama_makul' => $request->get('nama_makul'),
            'sks' => $request->get('sks'),
        ]);
        return response()->json([
            'data' => new MakulResource($makul),
            'message' => 'Data Makul Update Successfully',
            'success' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Makul $makul)
    {
        $makul->delete();
        return response()->json([
            'data' => [],
            'message' => 'Data Makul Deleted Successfully',
            'success' => true
        ]);
    }
}
