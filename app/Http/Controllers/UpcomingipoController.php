<?php

namespace App\Http\Controllers;

use App\Models\Upcomingipo;
use Illuminate\Http\Request;

class UpcomingipoController extends Controller
{
    public static function show_all_upcomingipo(Request $request)
    {
        $upcoming_ipos = Upcomingipo::all();
        return response()->json($upcoming_ipos, 200);
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
}
