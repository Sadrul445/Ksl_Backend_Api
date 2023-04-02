<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    //---[ SHOW_ALL_MEDIA ]---
    public function show_all_media()
    {
        $medias = Media::all();
        return response()->json($medias, 200);
    }
    //---[ SHOW_SINGLE_MEDIA ]---
    public function show_single_media(Request $request, $id)
    {
        $media = Media::find($id);
        return response()->json($media,200);
    }
    //---[ CREATE_BLOG ]---
    public function create_media(Request $request)
    {
        //validation
        $request->validate(
            [
                'title' => 'required|string',
                'image' => 'required',
                'newspaper_name' => 'required',
                'newspaper_url' => 'required',
                'newspaper_title' => 'required',
                'newspaper_description' => 'required',
                'blog_id' => 'required|integer|exists:blogs,id'
            ]
        );
        $decodedImage = base64_decode($request->input('image'));

        //store the decoded image data in the "Media_Images" directory
        $decoded_Media_Image_Path = 'Media_Images/' . time() . '.png';
        Storage::disk('public')->put($decoded_Media_Image_Path, $decodedImage);

        $media = Media::create(
            [
                'title' => $request->title,
                'image' => $decoded_Media_Image_Path,
                'newspaper_name' => $request->newspaper_name,
                'newspaper_url' => $request->newspaper_url,
                'newspaper_title' => $request->newspaper_title,
                'newspaper_description' => $request->newspaper_description,
                'blog_id' => $request->blog_id
            ]
        );
        return response()->json([
            'message' => 'Media Created Successfully',
            'status' => 'success',
        ], 200);
    }
    
    //---[ UPDATE_MEDIA ]---
    public function update_media(Request $request,$id)
    {
        $media = Media::findOrFail($id);

        //update the media fields
        $media->title = $request->input('title');
        $media->newspaper_name = $request->input('newspaper_name');
        $media->newspaper_url = $request->input('newspaper_url');
        $media->newspaper_title = $request->input('newspaper_title');
        $media->newspaper_description = $request->input('newspaper_description');
        $media->blog_id = $request->input('blog_id');

        // Update the image file if a new image is uploaded
        if ($request->hasFile('image')) {
            $destination = public_path('Media_Images/' . $media->image);
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $image = $request->file('image')->store('Updated_Media_Images/', 'public');
            $media->image = $image;
        }
        // Save the updated Media to the database
        $media->save();

        // Return the updated Media as a JSON response
        return response()->json([
            'message' => 'Media updated successfully',
            'status' => 'updated'
            // 'data' => $media,
        ]);
    }
}
