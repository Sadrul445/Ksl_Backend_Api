<?php

namespace App\Http\Controllers;
use App\Models\Ipo;
use Illuminate\Http\Request;

class IpoController extends Controller
{
    public static function show_all_ipo(Request $request)
    {
        $ipos = Ipo::all();
        return response()->json($ipos, 200);
    }
    public static function show_single_ipo(Request $request, $id)
    {
        $ipo = Ipo::findOrFail($id);
        return response()->json($ipo, 200);
    }
    public static function create_ipo(Request $request)
    {
        //validation
        $request->validate(
            [
                'company_name' => 'required|string',
                'cutt_off_date' => 'required|string',
                'minimum_application_amount' => 'required|string',
                'total_share' => 'required|string',
                'eps' => 'required|numeric',
                'nav' => 'required|numeric',
                'rate' => 'required|integer',
                'type' => 'required|string'
            ]
        );
        $ipos = Ipo::create(
            [
                'company_name' => $request->company_name,
                'cutt_off_date' => $request->cutt_off_date,
                'minimum_application_amount' => $request->minimum_application_amount,
                'total_share' => $request->total_share,
                'eps' => $request->eps,
                'nav' => $request->nav,
                'rate' => $request->rate,
                'type' => $request->type,
                'status'=>$request->status //set the default status as 'upcoming_ipo'  
            ]
        );
        return response()->json([
            'message' => 'IPO Created Successfully',
            'status' => 'success'
        ], 200);
    }
    public static function update_ipo(Request $request, $id)
    {
        $ipos = Ipo::findOrFail($id);

        $ipos->company_name = $request->input('company_name');
        $ipos->cutt_off_date = $request->input('cutt_off_date');
        $ipos->minimum_application_amount = $request->input('minimum_application_amount');
        $ipos->total_share = $request->input('total_share');
        $ipos->eps = $request->input('eps');
        $ipos->nav = $request->input('nav');
        $ipos->rate = $request->input('rate');
        $ipos->type = $request->input('type');
        $ipos->status = $request->input('status');
        $ipos->save();

        return response()->json([
            'message' => ' IPO Updated Successfully',
            'status' => 'updated'
        ], 200);
    }
    public static function delete_ipo(Request $request,$id)
    {
        if(empty($id)){
            return response()->json([
                'message' => 'Id not Found',
                'status' => 'error'
            ],400);
        }

        $ipo = Ipo::findOrFail($id);
        if(!$ipo){
            return response()->json([
                'message' => 'IPO not found',
                'status' => 'error'
            ],404);
        }

        $ipo->delete();
        return response()->json([
            'message' => 'IPO deleted successfully',
            'status' => 'success'
        ],200);

    }
}
