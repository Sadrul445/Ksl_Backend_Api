<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    //---[ CREATE_BRANCH ]---
    public function create_branches(Request $request)
    {
        //validation
        $request->validate([
            'branches_name' => 'required|string',
            'branches_address' => 'required|string',
            'branches_helpline' => 'required|string',
            'branches_email' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
        ]);
        $branch = Branch::create(
            [
                'branches_name' => $request->branches_name,
                'branches_address' => $request->branches_address,
                'branches_helpline' => $request->branches_helpline,
                'branches_email' => $request->branches_email,
                'user_id' => $request->user_id,
            ]
        );
        return response()->json([
            'message' => 'Branch Uploaded Successfully',
            'status' => 'success',
        ], 200);
    }
    //---[ SHOW_ALL_BRANCH ]---
    public function show_all_branches(Request $request)
    {
        $branches = Branch::all();
        return response()->json($branches, 200);
    }
    //---[ SHOW_SINGLE_BRANCH ]---
    public function show_single_branches(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);
        return response()->json($branch, 200);
    }
    //---[ UPDATE_BRANCH ]---
    public function update_branches(Request $request, $id)
    {
        $booth = Branch::findOrFail($id);

        $booth->branches_name = $request->input('branches_name');
        $booth->branches_address = $request->input('branches_address');
        $booth->branches_helpline = $request->input('branches_helpline');
        $booth->branches_email = $request->input('branches_email');
        $booth->user_id = $request->input('user_id');
        $booth->save();

        return response()->json(
            [
                'message' => 'Branch Updated Successfully',
                'status' => 'updated'
            ]
        );
    }
        //---[ DELETE_BRANCHES ]---
        public function delete_branches(Request $request, $id)
        {
            return Branch::destroy($id);
        }
}
