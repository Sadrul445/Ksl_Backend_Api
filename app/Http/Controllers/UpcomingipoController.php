<?php

namespace App\Http\Controllers;

use App\Models\Upcomingipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Response;

class UpcomingipoController extends Controller
{
    public static function show_all_upcomingipo(Request $request)
    {
        $upcoming_ipos = Upcomingipo::all();
        return response()->json($upcoming_ipos, 200);
    }
    public static function show_single_upcomingipo(Request $request, $id)
    {
        $upcoming_ipo = Upcomingipo::findOrFail($id);
        return response()->json($upcoming_ipo, 200);
    }
    public static function create_upcomingipo(Request $request)
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
        $upcoming_ipos = Upcomingipo::create(
            [
                'company_name' => $request->company_name,
                'cutt_off_date' => $request->cutt_off_date,
                'minimum_application_amount' => $request->minimum_application_amount,
                'total_share' => $request->total_share,
                'eps' => $request->eps,
                'nav' => $request->nav,
                'rate' => $request->rate,
                'type' => $request->type,
            ]
        );
        return response()->json([
            'message' => 'Upcoming IPO Created Successfully',
            'status' => 'success'
        ], 200);
    }
    public static function update_upcomingipo(Request $request, $id)
    {
        $upcoming_ipos = Upcomingipo::findOrFail($id);

        $upcoming_ipos->company_name = $request->input('company_name');
        $upcoming_ipos->cutt_off_date = $request->input('cutt_off_date');
        $upcoming_ipos->minimum_application_amount = $request->input('minimum_application_amount');
        $upcoming_ipos->total_share = $request->input('total_share');
        $upcoming_ipos->eps = $request->input('eps');
        $upcoming_ipos->nav = $request->input('nav');
        $upcoming_ipos->rate = $request->input('rate');
        $upcoming_ipos->type = $request->input('type');
        $upcoming_ipos->save();

        return response()->json([
            'message' => 'Upcoming IPO Updated Successfully',
            'status' => 'updated'
        ], 200);
    }
    public static function delete_upcomingipo(Request $request,$id)
    {
        if(empty($id)){
            return response()->json([
                'message' => 'Id not Found',
                'status' => 'error'
            ],400);
        }

        $upcoming_ipo = Upcomingipo::findOrFail($id);
        if(!$upcoming_ipo){
            return response()->json([
                'message' => 'Upcoming IPO not found',
                'status' => 'error'
            ],404);
        }

        $upcoming_ipo->delete();
        return response()->json([
            'message' => 'Upcoming IPO deleted successfully',
            'status' => 'success'
        ],200);

    }
}
