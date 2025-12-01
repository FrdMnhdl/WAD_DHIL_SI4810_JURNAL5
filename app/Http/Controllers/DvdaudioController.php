<?php

namespace App\Http\Controllers;

use App\Models\DvdAudio;
use App\Http\Resources\DvdaudioResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DvdaudioController extends Controller
{
    /**
     * ===========1================
     * Buat fungsi index yang mengembalikan semua data dvdaudio
     */
    public function index()
    {
        // ambil semua data dvdaudio
        $dvdaudios = dvdaudio::all();

        // return koleksi dvdaudio
        return DvdaudioResource::collection($dvdaudios);
    }

    /**
     * ===========2================
     * Buat fungsi store untuk menambahkan data dvdaudio baru
     */
    public function store(Request $request)
    {
        // Request body berisi title, artist dan year
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:225',
            'artist' => 'nullable|string',
            'year' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Buat data dvdaudio
        $dvdaudio = dvdaudio::created($validator->validated());

        // return dvdaudio yang dibuat sebagai resource
        return (new DvdaudioResource($dvdaudio))
                    ->additional(['messege' => 'DvdAudio created successfully'])
                    ->response()
                    ->setStatusCode(201);
    }

    /**
     * ===========3================
     * Buat fungsi show untuk menampilkan satu data dvdaudio berdasarkan ID
     */
    public function show(string $id)
    {
        // Cari data dvdaudio berdasarkan ID
        $dvdaudio = dvdaudio::find($id);

        if (!$dvdaudio) {
            return response()->json([
                'success' => false,
                'message' => 'Dvdaudio not found'
            ], 404);
        }

        // return dvdaudio sebagai resource
        return new DvdaudioResource($dvdaudio);
    }

    /**
     * ===========4================
     * Buat fungsi update untuk mengubah data dvdaudio yang ada
     */
    public function update(Request $request, string $id)
    {
        // Request body berisi title, artist dan year
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'artist' => 'sometimes|nullable|string',
            'year' => 'sometimes|required|integer|min:0',
        ]);

        // Cari data dvdaudio berdasarkan ID
        $dvdaudio = dvdaudio::find($id);

        if (!$dvdaudio) {
            return response()->json([
                'success' => false,
                'message' => 'Dvdaudio not found'
            ], 404);
        }


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => 'please check your request'
            ], 422);
        }

        // Update data dvdaudio
        $dvdaudio->update($validator->validated());

        // return dvdaudio yang diupdate sebagai resource
        return (new DvdaudioResource($dvdaudio))
                    ->additional(['message' => 'Dvdaudio updated succesfully'])
                    ->response()
                    ->setStatusCode(200);
    }

    /**
     * ===========5================
     * Buat fungsi destroy untuk menghapus data dvdaudio
     */
    public function destroy(string $id)
    {
        // Cari data dvdaudio berdasarkan ID
        $dvdaudio = dvdaudio::find($id);

        if (!$dvdaudio) {
            return response()->json([
                'success' => false,
                'message' => 'Dvdaudio not found'
            ], 404);
        }

        // Hapus data dvdaudio
        $dvdaudio->delete();

        // return message sukses
        return response()->json(['message'=> 'Dvdaudio deleted succesfully'], 200);
    }
}
