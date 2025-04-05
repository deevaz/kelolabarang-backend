<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($userId)
    {
        $products = Products::where('user_id', $userId)->get();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $userId)
    {
        $data = $request->validate([
            'kode_barang' => 'nullable|string',
            'nama_barang' => 'required|string',
            'stok_awal' => 'required|integer',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'kadaluarsa' => 'required|date',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori' => 'nullable|string',
            'total_stok' => 'required|integer',
        ]);
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('gambar_barang', 'public');
            $data['gambar'] = $gambarPath;
        }

        $data['user_id'] = $userId;

        $product = Products::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($userId, $id)
    {
        $product = Products::where('user_id', $userId)->where('id', $id)->first();

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userId, $id)
    {
        $product = Products::where('user_id', $userId)->where('id', $id)->first();

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'kode_barang' => 'required|string',
            'nama_barang' => 'required|string',
            'stok_awal' => 'required|integer',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'kadaluarsa' => 'required|date',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori' => 'required|string',
            'total_stok' => 'required|integer',

        ]);

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('gambar_barang', 'public');
            $data['gambar'] = $gambarPath;
        }
        $product = Products::find($request->id);

        if ($product) {
            $product->kode_barang = $request->kode_barang;
            $product->nama_barang = $request->nama_barang;
            $product->stok_awal = $request->stok_awal;
            $product->harga_beli = $request->harga_beli;
            $product->harga_jual = $request->harga_jual;
            $product->kadaluarsa = $request->kadaluarsa;
            $product->deskripsi = $request->deskripsi;
            if ($gambarPath) {
                $product->gambar = $gambarPath;
            }
            $product->kategori = $request->kategori;
            $product->total_stok = $request->total_stok;


            $product->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Produk berhasil diperbarui',
                'data' => $product
            ]);
        } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Produk tidak ditemukan'], 404);}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId, $id)
    {
        $product = Products::where('user_id', $userId)->where('id', $id)->first();

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil dihapus']);
    }
}
