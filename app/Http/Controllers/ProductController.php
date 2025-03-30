<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

            $products = Product::all();
            return response()->json($products);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_barang' => 'nullable|string',
            'nama_barang' => 'required|string',
            'stok_awal' => 'required|integer',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'harga_grosir' => 'required|numeric',
            'kadaluarsa' => 'required|date',
            'deskripsi' => 'nullable|string',
            'vendor' => 'nullable|string',
            'gambar' => 'nullable|string',
            'kategori' => 'nullable|string',
            'total_stok' => 'required|integer',
            'stok_masuk' => 'nullable|integer',
            'stok_keluar' => 'nullable|integer',
            'userId' => 'required|integer'
        ]);

        $product = Product::create($data);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'kode_barang' => 'nullable|string',
            'nama_barang' => 'required|string',
            'stok_awal' => 'required|integer',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'harga_grosir' => 'required|numeric',
            'kadaluarsa' => 'required|date',
            'deskripsi' => 'nullable|string',
            'vendor' => 'nullable|string',
            'gambar' => 'nullable|string',
            'kategori' => 'nullable|string',
            'total_stok' => 'required|integer',
            'stok_masuk' => 'nullable|integer',
            'stok_keluar' => 'nullable|integer',
            'userId' => 'required|integer'
        ]);

        $product->update($data);

        return response()->json([
            'message' => 'Produk berhasil diperbarui',
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
