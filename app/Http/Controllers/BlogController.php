<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    //---[ SHOW_ALL_BLOG ]---
    public function show_all_blog()
    {
        $blogs = Blog::all();

        //**if wanna show the Encoded Image Then enable this**

        //-------<< Base64_encoded_Image >>-------
        // foreach ($blogs as $blog) {
        //     $decodedImagePath = $blog->image;
        //     $decodedImageData = Storage::disk('public')->get($decodedImagePath);
        //     $encodedImageData = base64_encode($decodedImageData);
        //     $blog->encoded_image_data = $encodedImageData;
        // }

        return response()->json($blogs, 200);
    }

    //---[ SHOW_SINGLE_BLOG ]---
    public function show_single_blog(Request $request, $id)
    {
        $blog = Blog::find($id);

        //-------<< Base64_encoded_Image >>-------
        // $decodedImagePath = $blog->image;
        // $decodedImageData = Storage::disk('public')->get($decodedImagePath);
        // $encodedImageData = base64_encode($decodedImageData);
        // $blog->encoded_image_data = $encodedImageData;

        return response()->json($blog, 200);
    }
    //---[ CREATE_BLOG ]---
    public function create_blog(Request $request)
    {
        //validation
        $request->validate(
            [
                'title' => 'required|string',
                'author_name' => 'required|string',
                'publication_date' => 'required',
                'description' => 'required',
                'user_id' => 'required|integer|exists:users,id',
                'image' => 'required',
            ]
        );
        $decodedImage = base64_decode($request->input('image'));

        //store the decoded image data in the "Create_Blog_Decoded_Image" directory
        $decodedImagePath = 'Create_Blog_Decoded_Images/' . time() . '.png';
        Storage::disk('public')->put($decodedImagePath, $decodedImage);

        $blog = Blog::create(
            [
                'title' => $request->title,
                'author_name' => $request->author_name,
                'publication_date' => $request->publication_date,
                'description' => $request->description,
                'user_id' => $request->user_id,
                'image' => $decodedImagePath,
            ]
        );
        return response()->json([
            'message' => 'Blog Uploaded Successfully',
            'status' => 'success',
            // 'blog' => $blog
        ], 200);
    }

    //---[ UPDATE_BLOG ]---
    public function update_blog(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        // Update the blog post fields
        $blog->title = $request->input('title');
        $blog->author_name = $request->input('author_name');
        $blog->publication_date = $request->input('publication_date');
        $blog->description = $request->input('description');
        $blog->user_id = $request->input('user_id');

        // Update the image file if a new image is uploaded
        if ($request->hasFile('image')) {
            $destination = public_path('Create_Blog_Decoded_Images/' . $blog->image);
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $image = $request->file('image')->store('Updated_Blog_Images/', 'public');
            $blog->image = $image;
        }
        // Save the updated blog post to the database
        $blog->save();

        // Return the updated blog post as a JSON response
        return response()->json([
            'message' => 'Blog post updated successfully',
            'status' => 'updated'
            // 'data' => $blog,
        ]);
    }
    public function destroy_blog(Request $request, $id)
    {
        return Blog::destroy($id);
    }
}
