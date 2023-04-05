<?php

namespace App\Http\Controllers;

use App\Models\Booth;
use Illuminate\Http\Request;

class BoothController extends Controller
{
    //---[ CREATE_BOOTHS ]---
    public function create_booths(Request $request)
    {
        //validation
        $request->validate([
            'booths_name' => 'required|string',
            'booths_address' => 'required|string',
            'booths_helpline' => 'required|string',
            'booths_email' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
        ]);
        $booth = Booth::create(
            [
                'booths_name' => $request->booths_name,
                'booths_address' => $request->booths_address,
                'booths_helpline' => $request->booths_helpline,
                'booths_email' => $request->booths_email,
                'user_id' => $request->user_id,
            ]
        );
        return response()->json([
            'message' => 'Booth Created Successfully',
            'status' => 'success',
        ], 200);
    }
    //---[ SHOW_ALL_BOOTHS ]---
    public function show_all_booths(Request $request)
    {
        $booths = Booth::all();
        return response()->json($booths, 200);
    }
    //---[ SHOW_SINGLE_BOOTHS ]---
    public function show_single_booths(Request $request, $id)
    {
        $booth = Booth::findOrFail($id);
        return response()->json($booth, 200);
    }
    //---[ UPDATE_BOOTHS ]---
    public function update_booths(Request $request, $id)
    {
        $booth = Booth::findOrFail($id);

        $booth->booths_name = $request->input('booths_name');
        $booth->booths_address = $request->input('booths_address');
        $booth->booths_helpline = $request->input('booths_helpline');
        $booth->booths_email = $request->input('booths_email');
        $booth->user_id = $request->input('user_id');
        $booth->save();

        return response()->json(
            [
            'message' => 'Booths Updated Successfully',
            'status' => 'updated'
        ]);
    }
    //---[ DELETE_BOOTHS ]---
    public function delete_booths(Request $request, $id)
    {
        return Booth::destroy($id);
    }
}
