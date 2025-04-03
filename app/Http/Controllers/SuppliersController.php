<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suppliers;

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
        $data = $request->validate([
            'nama_supplier' => 'required|string',
            'no_rekening' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $data['user_id'] = $userId;

        $supplier = Suppliers::create($data);

        return response()->json([
            'message' => 'Supplier berhasil ditambahkan',
            'data' => $supplier
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
        $supplier = Suppliers::where('user_id', $userId)->where('id', $id)->first();

        if (!$supplier) {
            return response()->json(['message' => 'Supplier tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'nama_supplier' => 'required|string',
            'no_telp' => 'nullable|string',
            'no_Rekening' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $supplier = Suppliers::find($request->id);

        if ($supplier) {
            $supplier->nama_supplier = $request->nama_supplier;
            $supplier->no_telp = $request->no_telp;
            $supplier->no_Rekening = $request->no_Rekening;
            $supplier->catatan = $request->catatan;

            $supplier->save();

            return response()->json([
            'message' => 'Supplier berhasil diperbarui',
            'data' => $supplier
        ]);
        } else {
            return response()->json(['message' => 'Supplier tidak ditemukan'], 404);


    }}

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
