<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Business;
use App\Models\Appointment;
use App\Models\OtherDetail;
use Illuminate\Http\Request;
use App\Mail\NewBookedEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class BookingController extends Controller
{
    public function index($id)
    {
        $services = fractal(Service::query()->where('created_by', $id)->orderBy('ordering', 'asc')->get(),
            function ($value) {
                $value->booking_link = route('book', ['id' => Crypt::encrypt($value->id)]);

                return collect($value)->toArray();
            })->toArray()['data'];

        $business = Business::query()->where('id', $id)->first();

        return view('welcome', compact('services', 'business'));
    }

    public function book(Request $request)
    {
        $id = Crypt::decrypt($request->id);

        return view('layouts.external', [
            'component' => 'booking-page',
            'data'      => [
                'id'                    => $id,
                'service'               => Service::query()->where('id', $id)->first(),
                'slots_link'            => route('slots'),
                'other_details_link'    => route('details'),
                'reserve_link'          => route('reserve'),
                'reserve_checking_link' => route('reserve.checking'),
            ],
        ]);
    }

    public function slots(Request $request)
    {
        $appointments = Appointment::query()
                                   ->where('service', $request->service)
                                   ->where('date_appoint', Carbon::parse($request->input_date)->format('Y-m-d'))
                                   ->get()->toArray();

        return fractal($appointments, function ($value) {
            $value['time_appoint'] = Carbon::parse($value['time_appoint'])->format('h:iA');

            return $value;
        });
    }

    public function details()
    {
        return fractal(OtherDetail::query()->get()->toArray(), function ($value) {
            return [
                'field' => $value['field'],
                'type'  => $value['type'],
                'value' => '',
            ];
        });
    }

    public function reserveChecking(Request $request)
    {
        return Customer::query()
                       ->join('appointments as a', 'a.id', '=', 'customers.appoint_id')
                       ->where('a.date_appoint', Carbon::parse($request->date_appoint)->format('Y-m-d'))
                       ->where('email', $request->email)
                       ->count() > 0 ? 'exist' : 'none';
    }

    public function reserve(Request $request)
    {
        $appointment = Appointment::query()
                                  ->where('id', $request->appoint_id)
                                  ->with(['hasOneService'])
                                  ->first()
                                  ->toArray();

        $customer = Customer::create([
            'service_id'    => $appointment['has_one_service']['id'],
            'created_by'    => $appointment['has_one_service']['created_by'],
            'appoint_id'    => $appointment['id'],
            'name'          => $request->name,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'is_verified'   => 'no',
            'other_details' => json_encode($request->other_details),
        ]);

        Mail::to([$customer->email])->send(new NewBookedEmail($appointment, $customer));

        return ['success' => 'E-mail sent'];
    }

    public function confirmPage(Request $request)
    {
        $appoint_id = decrypt($request->id);

        Customer::query()
                ->where('appoint_id', $appoint_id)
                ->where('is_verified', 'no')
                ->update(['is_verified' => substr(encrypt($appoint_id), -6, -1)]);

        $customer_id = Customer::query()->where('appoint_id', $appoint_id)->first()->id;

        Appointment::query()->where('id', $appoint_id)->update(['customer_id' => $customer_id]);

        $appointment = Appointment::query()->where('id', $appoint_id)->first();
        $service     = Service::query()->where('id', $appointment->service)->first();
        $customer    = Customer::query()
                               ->where('appoint_id', $appoint_id)
                               ->orderBy('id', 'desc')
                               ->with(['serviceHasOne', 'appointmentHasOne'])
                               ->first()->toArray();

        $business = Business::query()->where('id', $service->created_by)->first();

        return view('layouts.external', [
            'component' => 'booking-confirm',
            'data'      => [
                'customer' => $customer,
                'business' => $business,
            ],
        ]);
    }
}
