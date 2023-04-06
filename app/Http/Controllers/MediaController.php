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
        return response()->json($media, 200);
    }
    //---[ CREATE_MEDIA ]---
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
                'user_id' => 'required|integer|exists:users,id'
            ]
        );
        $decodedImage = base64_decode($request->input('image'));

        //store the decoded image data in the "Media_Images" directory
        $decoded_Media_Image_Path = 'KSL_Media_Image_' . time() . '.png';
        Storage::disk('public')->put("Media_Images/{$decoded_Media_Image_Path}", $decodedImage);
        
        $media = Media::create(
            [
                'title' => $request->title,
                'image' => $decoded_Media_Image_Path,
                'newspaper_name' => $request->newspaper_name,
                'newspaper_url' => $request->newspaper_url,
                'newspaper_title' => $request->newspaper_title,
                'newspaper_description' => $request->newspaper_description,
                'user_id' => $request->user_id
            ]
        );

        $media->image = "Updated_Media_Images/{$decoded_Media_Image_Path}";
        return response()->json([
            'message' => 'Media Created Successfully',
            'status' => 'success',
        ], 200);
    }

    //---[ UPDATE_MEDIA ]---
    public function update_media(Request $request, $id)
    {
        $media = Media::findOrFail($id);

        //update the media fields
        $media->title = $request->input('title');
        $media->newspaper_name = $request->input('newspaper_name');
        $media->newspaper_url = $request->input('newspaper_url');
        $media->newspaper_title = $request->input('newspaper_title');
        $media->newspaper_description = $request->input('newspaper_description');
        $media->user_id = $request->input('user_id');

        // Update the image file if a new image is uploaded
        if ($request->hasFile('image')) {
            $destination = public_path('Media_Images/' . $media->image);
            if (File::exists($destination)) {
                File::delete($destination);
            }
        }
        // Decode->the encoded input image
        $base64_encode_image = $request->input('image');
        $image_data = base64_decode($base64_encode_image);

        //Naming & Storing File
        $image_name = 'KSL_Media_Image_' . time() . '.png';
        Storage::disk('public')->put("Updated_Media_Images/{$image_name}", $image_data);
        $media->image = "Updated_Media_Images/{$image_name}";

        // Save the updated Media to the database
        $media->save();
        // Return the updated Media as a JSON response
        return response()->json([
            'message' => 'Media Updated Successfully',
            'status' => 'updated'
            // 'data' => $media,
        ]);
    }
    public function destroy_media(Request $request, $media_id)
    {
        $user_id = $request->input('user_id');
        $media = Media::where('id', $media_id)
                            ->where('user_id', $user_id)
                            ->first();
        if (!$media) {
            return response()->json([
                'message' => 'Media not found',
                'status' => 'error'
            ], 404);
        }  
        $media->delete();
        return response()->json([
            'message' => 'Media Deleted Successfully',
            'status' => 'success'
        ], 200);
    }
}
