<?php

namespace App\Http\Controllers;

use Excel;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Mail\BookedCancelled;
use App\Exports\AppointmentExport;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function search(Request $request)
    {
        $appointment = Appointment::query()
                                  ->selectRaw('appointments.*')
                                  ->leftJoin('customers as c', 'c.id', '=', 'appointments.customer_id')
                                  ->whereBetween('date_appoint', [$request->start_date, $request->end_date])
                                  ->when($request->code, function ($q) use ($request) {
                                      return $q->where('is_verified', 'LIKE', "%{$request->code}%");
                                  })
                                  ->when($request->appointee, function ($q) use ($request) {
                                      return $q->where('name', 'LIKE', "%{$request->appointee}%");
                                  })
                                  ->with(['hasOneService', 'hasOneCustomer'])
                                  ->get()->toArray();

        $result = fractal($appointment, function ($value) {
            $value['day']         = Carbon::parse($value['date_appoint'])->day;
            $value['day_name']    = Carbon::parse($value['date_appoint'])->dayName;
            $value['time_format'] = Carbon::parse($value['time_appoint'])->format('h:i A');

            return $value;
        })->toArray();

        return $result;
    }

    public function cancelBooking(Request $request)
    {
        Customer::query()->where('id', $request->item['has_one_customer']['id'])->delete();

        Appointment::query()
                   ->where('id', $request->item['id'])
                   ->where('customer_id', "{$request->item['has_one_customer']['id']}")
                   ->update([
                       'customer_id' => '',
                   ]);

        Mail::to([$request->item['has_one_customer']['email']])
            ->send(new BookedCancelled($request->item, $request->message));

        return ['success' => true];
    }

    public function exportFile(Request $request)
    {
        $now          = Carbon::now()->format('Y_m_d-h:mA');
        $service_name = Service::query()->where('id', $request->service)->first()->name;

        return Excel::download(new AppointmentExport($request->dated, $request->service, $service_name),
            "{$service_name}_Appointments_{$now}.xlsx");
    }

    public function getServices()
    {
        return Service::query()->select(['id', 'name'])->where('created_by', auth()->user()->business_id)->get();
    }
}
