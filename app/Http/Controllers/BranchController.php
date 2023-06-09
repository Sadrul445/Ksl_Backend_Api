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
            'branches_helpline_1' => 'required|string',
            'branches_helpline_2' => 'required|string',
            'branches_email' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
        ]);
        $branch = Branch::create(
            [
                'branches_name' => $request->branches_name,
                'branches_address' => $request->branches_address,
                'branches_helpline_1' => $request->branches_helpline_1,
                'branches_helpline_2' => $request->branches_helpline_2,
                'branches_email' => $request->branches_email,
                'user_id' => $request->user_id,
            ]
        );
        return response()->json([
            'message' => 'Branch Created Successfully',
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
        $branches = Branch::findOrFail($id);

        $branches->branches_name = $request->input('branches_name');
        $branches->branches_address = $request->input('branches_address');
        $branches->branches_helpline_1 = $request->input('branches_helpline_1');
        $branches->branches_helpline_2 = $request->input('branches_helpline_2');
        $branches->branches_email = $request->input('branches_email');
        $branches->user_id = $request->input('user_id');
        $branches->save();

        return response()->json(
            [
                'message' => 'Branch Updated Successfully',
                'status' => 'updated'
            ]
        );
    }
    //---[ DELETE_BRANCHES ]---
    public function delete_branches(Request $request, $branch_id)
    {
        $user_id = $request->input('user_id');
        $branch = Branch::where('id', $branch_id)
                            ->where('user_id', $user_id)
                            ->first();
        if (!$branch) {
            return response()->json([
                'message' => 'Branch not found',
                'status' => 'error'
            ], 404);
        }  
        $branch->delete();
        return response()->json([
            'message' => 'Branch Deleted Successfully',
            'status' => 'success'
        ], 200);
    }
}
