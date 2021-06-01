<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\CarbonCopy;
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
        OtherDetail::query()->where('created_by', auth()->id())->delete();

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
        return OtherDetail::query()->orderBy('id','desc')->get();
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

    public function storeNotifiable(Request $request)
    {
        CarbonCopy::updateOrCreate([
            'id' => $request->id ?? ''
        ], [
            'email'      => $request->email,
            'created_by' => auth()->user()->business_id,
            'isActive'   => $request->isActive,
        ]);

        return ['success' => true];
    }

    public function getNotifiable()
    {
        return CarbonCopy::all();
    }

    public function deleteNotifiable(Request $request)
    {
        CarbonCopy::query()->where('id', $request->id)->delete();

        return ['success' => true];
    }
}
