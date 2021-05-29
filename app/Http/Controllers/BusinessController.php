<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\OtherDetail;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        $business = Business::query()->where('id', auth()->user()->business_id)->first();

        return view('customer', compact('business'));
    }

    public function addOtherDetails(Request $request)
    {
        foreach ($request->input() as $value) {
            OtherDetail::updateOrCreate(
                ['id' => $value['id'] ?? ''],
                [
                    'field'      => $value['field'],
                    'type'       => $value['type'] ?? '',
                    'created_by' => auth()->id(),
                ]
            );
        }

        return ['success' => true];
    }

    public function getOtherDetails()
    {
        return OtherDetail::all();
    }

    public function businessUpdate(Request $request)
    {
        Business::updateOrCreate(['id' => $request->id], [
            "name"           => $request->name,
            "website"        => $request->website,
            "phone"          => $request->phone,
            "email"          => $request->email,
            "facebook"       => $request->facebook,
            "address"        => $request->address,
            "photo_url"      => $request->photo_url,
            "lat"            => $request->lat,
            "long"           => $request->long,
            "booking_policy" => $request->booking_policy,
        ]);

        return ['success' => true];
    }
}
