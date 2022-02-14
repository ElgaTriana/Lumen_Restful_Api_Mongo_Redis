<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Listminuman;

use Illuminate\Support\Facades\Redis;

use Illuminate\Support\Facades\cache;

use Illuminate\Support\Facades\Validator;

class ListminumanController extends Controller
{
    public function index()
    {
        $var = Cache::remember('listminuman', 10, function() {
            return Listminuman::all();
        });

        return response()->json([
            'success' => true,
            'message' =>'List Minuman Berhasil Ditampilkan',
            'data'    => $var
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_minuman'  => 'required|unique:listminuman',
            'harga'         => 'required',
            'status'        => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);
        } else {
            $var = Listminuman::create([
                'nama_minuman'      => $request->input('nama_minuman'),
                'harga'             => $request->input('harga'),
                'deskripsi_minuman' => $request->input('deskripsi_minuman'),
                'status'            => $request->input('status'),
            ]);

            Cache::flush();

            if ($var) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'List Minuman Berhasil Disimpan!',
                    'data'      => $var
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'List Minuman Gagal Disimpan!',
                ], 400);
            }
        }
    }

    public function show(Request $request, $id)
    {
        $var = Cache::remember('listminuman' . $request->input('id'), 10, function() use ($id) {
            return Listminuman::find($id);
        });

        $var = Listminuman::find($id);

        if ($var) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail List Minuman!',
                'data'      => $var
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'List Minuman Tidak Ditemukan!',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'nama_minuman'  => 'required',
            'harga'         => 'required',
            'status'        => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $var = Listminuman::find($id)->update([
                'nama_minuman'      => $request->input('nama_minuman'),
                'harga'             => $request->input('harga'),
                'deskripsi_minuman' => $request->input('deskripsi_minuman'),
                'status'            => $request->input('status'),
            ]);

            Cache::flush();

            if ($var) {
                return response()->json([
                    'success' => true,
                    'message' => 'List Minuman Berhasil Diupdate!',
                    'data' => $var
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'List Minuman Gagal Diupdate!',
                ], 400);
            }

        }
    }

    public function destroy($id)
    {
        $var = Listminuman::find($id)->first();

        $var->delete();

        if ($var) {
            return response()->json([
                'success' => true,
                'message' => 'Listminuman Berhasil Dihapus!',
            ], 200);
        }

    }
}
