<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return view('image.index', compact('images'));
    }

    public function showForm()
    {
        return view('image.upload');
    }

    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan gambar ke penyimpanan server (storage/app/public)
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = Storage::disk('public')->put($imageName, file_get_contents($image));

        // Simpan detail gambar ke database
        $imageRecord = new Image; // Pastikan Anda sudah memiliki model yang sesuai, misalnya `Image`
        $imageRecord->filename = $imageName; // Atau path lengkap jika perlu
        // Tambahkan detail lainnya jika ada
        $imageRecord->save();

        // Pengembalian tanggapan
        return response()->json(['success' => 'Gambar berhasil diunggah dan disimpan.']);
    }

}
