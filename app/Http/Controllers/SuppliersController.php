<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suppliers;
use Illuminate\Support\Facades\Validator;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($userId)
    {
        $suppliers = Suppliers::where('user_id', $userId)->get();
        return response()->json($suppliers);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $userId)
    {
        $data = new Suppliers();
        $data->nama_supplier = $request->nama_supplier;
        $data->no_telp = $request->no_telp;
        $data->no_rekening = $request->no_rekening;
        $data->catatan = $request->catatan;
        $data->user_id = $userId;
        $data->save();

        $rules = [
            'nama_supplier' => 'required|string',
            'no_telp' => 'nullable|string',
            'no_rekening' => 'nullable|string',
            'catatan' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }


        return response()->json([
            'message' => 'Supplier berhasil ditambahkan',
            'data' => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $userId , $id)
    {
        $supplier = Suppliers::where('user_id', $userId)->where('id', $id)->first();

        if(!$supplier) {
            return response()->json(['message' => 'Supplier tidak ditemukan'], 404);
        }

        return response()->json($supplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userId, $id)
    {
        $rules = [
            'nama_supplier' => 'required|string',
            'no_telp' => 'nullable|string',
            'no_rekening' => 'nullable|string',
            'catatan' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = Suppliers::where('user_id', $userId)->where('id', $id)->first();
        if (!$data) {
            return response()->json(['message' => 'Supplier tidak ditemukan'], 404);
        }

        $data->nama_supplier = $request->nama_supplier;
        $data->no_telp = $request->no_telp;
        $data->no_rekening = $request->no_rekening;
        $data->catatan = $request->catatan;
        $data->user_id = $userId;
        $data->save();


        return response()->json([
            'status' => 'true',
            'message' => 'Supplier berhasil diperbaharui',
            'data' => $data
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId,  $id)
    {
        $supplier = Suppliers::where('user_id', $userId)->where('id', $id)->first();

        if (!$supplier) {
            return response()->json(['message' => 'Supplier tidak ditemukan'], 404);
        }

        $supplier->delete();

        return response()->json(['message' => 'Supplier berhasil dihapus']);
    }
}
