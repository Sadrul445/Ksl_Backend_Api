<?php

namespace App\Http\Controllers;
use App\Models\Booth;
use Illuminate\Http\Request;

class BoothController extends Controller
{
    //---[ CREATE_BOOTHS ]---
    public function create_booths(Request $request){
        //validation
        $request->validate([
            ''
        ]);
        //
    }
    //---[ SHOW_ALL_BOOTHS ]---
    public function show_all_booths(Request $request){
        $booths = Booth::all();
        return response()->json($booths,200);
    }
    //---[ SHOW_SINGLE_BOOTHS ]---
    public function show_single_booths(Request $request,$id){
        $booths = Booth::find($id);
        return response()->json($booths,200);
    }
    //---[ UPDATE_BOOTHS ]---
    public function update_booths(Request $request,$id){
        
    }
    //---[ DELETE_BOOTHS ]---
    public function destroy_booths(Request $request,$id){
        
    }
}
