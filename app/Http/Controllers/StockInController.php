<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockIn;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\StockInItems;

class StockInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($userId)
    {
        $stockIn = StockIn::with('items')->where('user_id', $userId)->get();

        if ($stockIn->isEmpty()) {
            return response()->json([
                'kode' => 204,
                'status' => 'error',
                'message' => 'Data stock-in tidak ditemukan'
            ], 204);
        }

        $data = $stockIn->map(function ($item) {
            return [
                'id' => (string) $item->id,
                'pemasok' => $item->pemasok,
                'userId' => (string) $item->user_id,
                'catatan' => $item->catatan,
                'total_harga' => $item->total_harga,
                'tanggal_masuk' => $item->tanggal_masuk,
                'barang' => $item->items->map(function ($barang) {
                    return [
                        'nama' => $barang->nama,
                        'harga' => $barang->harga,
                        'jumlah_stok_masuk' => $barang->jumlah_stok_masuk,
                        'total_stok' => $barang->total_stok,
                    ];
                }),
            ];
        });

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $userId)
    {
        $data = new StockIn();
        $data->pemasok = $request->pemasok;
        $data->catatan = $request->catatan;
        $data->tanggal_masuk = $request->tanggal_masuk;
        $data->total_harga = $request->total_harga;
        $data->user_id = $userId;
        $data->save();

        $rules = [
            'pemasok' => 'required|string|max:255',
            'catatan' => 'nullable|string|max:255',
            'tanggal_masuk' => 'required|date',
            'total_harga' => 'required|numeric',


            'barang' => 'required|array',
            'barang.*.nama' => 'required|string|max:255',
            'barang.*.harga' => 'required|numeric',
            'barang.*.jumlah_stok_masuk' => 'required|integer',
            'barang.*.total_stok' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $barangData = [];
        foreach ($request->barang as $item) {
            $barangData[] = new StockInItems([
                'nama' => $item['nama'],
                'harga' => $item['harga'],
                'jumlah_stok_masuk' => $item['jumlah_stok_masuk'],
                'total_stok' => $item['total_stok'],
                'user_id' => $userId,
            ]);
        }

        $data->items()->saveMany($barangData);

        $responseData = [
            'barang' => $data->items->map(function ($barang) {
                return [
                    'nama' => $barang->nama,
                    'harga' => $barang->harga,
                    'jumlah_stok_masuk' => $barang->jumlah_stok_masuk,
                    'total_stok' => $barang->total_stok,
                ];
            }),
            'tanggal_masuk' => $data->tanggal_masuk,
            'pemasok' => $data->pemasok,
            'catatan' => $data->catatan,
            'total_harga' => $data->total_harga,
            'id' => (string) $data->id,
            'userId' => (string) $data->user_id,
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Stock-in berhasil ditambahkan',
            'data' => $responseData
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId,  $id)
    {
        $stockIn = StockIn::where('user_id', $userId)->where('id', $id)->first();

        if (!$stockIn) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stok tidak ditemukan'
            ], 404);
        }

        $stockIn->items()->delete();
        $stockIn->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Stok berhasil dihapus'
        ], 200);
    }
}
