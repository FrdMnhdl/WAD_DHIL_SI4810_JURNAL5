<?php

namespace App\Http\Controllers;

use App\Models\Vhs;
use App\Http\Resources\VhsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VhsController extends Controller
{
    /**
     * ===========1================
     * Buat fungsi index yang mengembalikan semua data vhs
     */
    public function index()
    {
        // ambil semua data vhs
        // $vhss = ....
        $vhs = Vhs::all();
        

        // return koleksi vhs
        // return ....
        return VhsResource::collection($vhs);
    }

    /**
     * ===========2================
     * Buat fungsi store untuk menambahkan data vhs baru
     */
    public function store(Request $request)
    {
        // Request body berisi title, director dan year
        $validator = Validator::make($request->all(), [
            'title'          => 'required|string|max:255',
            'director'         => 'required|string|max:255',
            'year' => 'required|digits:4|integer|min:1000|max:' . (date('Y')),
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                // 'success' => false,
                // 'errors' => ....
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Buat data vhs
        // $vhs = ....
         $vhs= Vhs::create(validator->validated());
         
        // return vhs yang dibuat sebagai resource
        // return ....
             return (new VhsResource($vhs))
                ->additional(['message' => 'vhs created successfully'])
                ->response()
                ->setStatusCode(201);

    }

    /**
     * ===========3================
     * Buat fungsi show untuk menampilkan satu data vhs berdasarkan ID
     */
    public function show(string $id)
    {
        // Cari data vhs berdasarkan ID
        // $vhs = ....
         $vhs = Vhs::find($id);

        if (!vhs) {
                // 'message' => ....
                return response()->json(['message' => 'vhs not found',
                'succes'=> false
            ], 404);
        }

        // return vhs sebagai resource
        // return ....
        return new vhsresource($vhs);
    }
    

    /**
     * ===========4================
     * Buat fungsi update untuk mengubah data vhs yang ada
     */
    public function update(Request $request, string $id)
    {
        // Request body berisi title, director dan year
            $validator = Validator::make($request->all(), [
            'title'          => 'sometimes|required|string|max:255',
            'director'         => 'sometimes|required|string|max:255',
            'year' => 'sometimes|required|digits:4|integer|min:1000|max:' . (date('Y')),
            
        ]);

        // Cari data vhs berdasarkan ID
        // $vhs = ....
         $vhs = Vhs::find($id);

        if (!$vhs) {
                // 'success' => false,
                // 'message' => ....
            return response()->json(['message' => 'vhs not found'], 404);
            }
        if ($validator->fails()) {
            return response()->json([
                // 'success' => false,
                // 'errors' => ....
                   'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Update data vhs
        // $vhs->....
         $vhs->update($request->only(['title', 'director', 'year']));
       

        // return vhs yang diupdate sebagai resource
        // return ....
         return (new VhsResource($vhs))
                ->additional(['message' => 'vhs updated successfully'])
                ->response()
                ->setStatusCode(200);
    }

    /**
     * ===========5================
     * Buat fungsi destroy untuk menghapus data vhs
     */
    public function destroy(string $id)
    {
        // Cari data vhs berdasarkan ID
        // $vhs = ....
         $vhs = Vhs::find($id);

        if (!$vhs) {
                // 'message' => ....
                return response()->json(['message' => 'vhs not found',
                 'success' => false
            ], 404);
        }

        // Hapus data vhs
        // $vhs->....
         $Vhs->delete();
       
        // return message sukses
        // return ....
         return response()->json(['message' => 'Vhs deleted successfully'], 200);
    }
}
