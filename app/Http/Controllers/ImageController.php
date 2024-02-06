<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::orderBy('id', 'desc')->paginate(10);
        return view('image.index', compact('images'));
    }

    public function create()
    {
        return view('image.upload');
    }
    public function create_multiple()
    {
        return view('image.upload_multiple');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = Storage::disk('public')->put($imageName, file_get_contents($image));

        $imageRecord = new Image;
        $imageRecord->filename = $imageName;
        $imageRecord->save();

        return response()->json(['success' => 'Gambar berhasil diunggah dan disimpan.']);
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        Storage::delete('public/' . $image->filename);
        $image->delete();

        return redirect('/image')->with('success', 'Image deleted successfully');
    }

    public function store_multiple(Request $request)
    {
        $images = $request->file('image');

        if (!is_array($images)) {
            $images = [$images];
        }

        $storedImages = [];

        foreach ($images as $image) {
            if ($image) {
                $imageName = time().'_'.$image->getClientOriginalName();
                $imagePath = Storage::disk('public')->put($imageName, file_get_contents($image));

                $imageRecord = new Image;
                $imageRecord->filename = $imageName;
                $imageRecord->save();

                $storedImages[] = $imageRecord;
            }
        }

        return response()->json([
            'message' => 'Images successfully stored',
            'data' => $storedImages,
        ]);
    }
}
