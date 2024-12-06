<?php

namespace App\Http\Controllers\Api;

use App\Models\Dosen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DosenResource;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dosen = Dosen::latest()->get();
        return response()->json([
            'data' => DosenResource::collection($dosen),
            'message' => 'Fetch All Dosen',
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
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|string|max:255',
                'nip' => 'required|numeric|digits_between:1,20|unique:dosen',
                'email' => 'required|string|unique:dosen'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }
        $dosen = Dosen::create([
            'nama' => $request->get('nama'),
            'nip'  => $request->get('nip'),
            'email' => $request->get('email')
        ]);
        return response()->json([
            'data' => new DosenResource($dosen),
            'message' => 'Data Dosen Created Successfully',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(dosen $dosen)
    {
        return response()->json([
            'data' => new DosenResource($dosen),
            'message' => 'Data Dosen Found',
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
    public function update(Request $request, Dosen $dosen)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nip' => 'required|numeric|digits_between:1,20|unique:dosen,nip,' . $dosen->id,
            'email' => 'required|string|unique:dosen,email,' . $dosen->id
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }
        $dosen->update([
            'nama' => $request->get('nama'),
            'nip' => $request->get('nip'),
            'email' => $request->get('email')
        ]);
        return response()->json([
            'data' => new DosenResource($dosen),
            'message' => 'Data Dosen Updated Successfully',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dosen $dosen)
    {
        $dosen->delete();
        return response()->json([
            'data' => [],
            'message' => 'Data Dosen Deleted Successfully',
            'success' => true
        ]);
    }
}
