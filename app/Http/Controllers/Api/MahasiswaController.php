<?php

namespace App\Http\Controllers\Api;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MahasiswaResource;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::latest()->get();
        return response()->json([
            'data' => MahasiswaResource::collection($mahasiswa),
            'message' => 'Fetch All Mahasiswa',
            'success' => true

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            'nama'  => 'required|string|max:255',
            'nim'   => 'required|string|unique:mahasiswa',
            'email' => 'required|string|unique:mahasiswa'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data'      => [],
                'message'   => $validator->errors(),
                'success'   => false
            ]);
        }
        $mahasiswa = Mahasiswa::create([
            'nama'  => $request->get('nama'),
            'nim'   => $request->get('nim'),
            'email' => $request->get('email')
        ]);
        return response()->json([
            'data' => new MahasiswaResource($mahasiswa),
            'message' => 'Mahasiswa Created Successfully',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return response()->json([
            'data' => new MahasiswaResource($mahasiswa),
            'message' => 'Data Mahasiswa Found',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validator  = Validator::make($request->all(), [
            'nama'  => 'required|string|max:255',
            'nim'   => 'required|string|max:20|unique:mahasiswa,nim,' . $mahasiswa->id,
            'email' => 'required|string|email|max:255|unique:mahasiswa,email,' . $mahasiswa->id,
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data'      => [],
                'message'   => $validator->errors(),
                'success'   => false
            ]);
        }
        $mahasiswa->update([
            'nama' => $request->get('nama'),
            'nim' => $request->get('nim'),
            'email' => $request->get('email'),
        ]);
        return response()->json([
            'data' => new MahasiswaResource($mahasiswa),
            'message' => 'Mahasiswa Update Successfully',
            'success' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return response()->json([
            'data' => [],
            'message' => 'Mahasiswa Deleted Successfully',
            'success' => true
        ]);
    }
}
