<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\AppointmentStoreRequest;
use DB;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('appointment');
    }

    public function table()
    {
        return DataTables::of(Service::all())->setTransformer(function ($value) {
            $value->created_at_display = Carbon::parse($value->created_at)->format('F j, Y');
            $value->appoint_link       = route('appoint', ['id' => $value->id]);

            return collect($value)->toArray();
        })->make(true);
    }

    public function create()
    {
        return view('appointment-form');
    }

    public function store(AppointmentStoreRequest $request)
    {
        $service = $request->service;
        Service::updateOrCreate(
            ['id' => $service['id'] ?? ''],
            [
                'name'            => $service['name'],
                'desc'            => $service['desc'],
                'ordering'        => $service['ordering'],
                'cost'            => 0,
                'time'            => 0,
                'buffer'          => 0,
                'private_service' => 'no',
                'color'           => 'black',
                'video_meeting'   => 'no',
                'created_by'      => auth()->user()->business_id,
            ]
        );

        return ['success' => 'New Appoint has been added!'];
    }

    public function show($id)
    {
        return view('appointment-form', [
            'service' => Service::query()->where('id', $id)->first(),
            'appoint' => Appointment::query()->where('service', $id)->get(),
        ]);
    }

    public function saveSchedule(Request $request)
    {
        foreach ($request->schedule['sched_time'] as $value) {
            Appointment::updateOrCreate(
                ['id' => $value['id'] ?? ''],
                [
                    'customer_id'  => '',
                    'provider'     => '',
                    'service'      => $request->service['id'],
                    'date_appoint' => $request->schedule['sched_date'],
                    'time_appoint' => $value['time_appoint'],
                    'notes'        => '',
                ]
            );

//            Mail::send([], [], function ($message) use ($request, $value) {
//                $dated = Carbon::parse($request->schedule['sched_date'])->format('F j, Y');
//                $timed = Carbon::parse($value['time_appoint'])->format('H:iA');
//                $now   = now();
//                $message->to(['yaramayservices@gmail.com', 'sab_princes@yahoo.com'])
//                        ->from('do-not-reply@poloksa-ph.com')
//                        ->subject("SLOT OPENED - POLO-KSA {$now}")
//                        ->setBody("
//                        Service: {$request->service['name']}
//                        Date of Appointment: {$dated}
//                        Time: {$timed}
//                        ");
//            });
        }

        return ['success' => 'New Appoint has been added!'];
    }

    public function getSchedule(Request $request)
    {
        $result = Appointment::query()
                             ->where('date_appoint', $request->cal_date)
                             ->where('service', $request->service)
                             ->get();

        return collect($result)->toArray();
    }

    public function listSchedule(Request $request)
    {
        $open = DB::select("SELECT COUNT(*) as slot, date_appoint, customer_id  FROM appointments a where a.customer_id  = '' and a.service = {$request->id} group by date_appoint, customer_id");

        $closed = DB::select("SELECT COUNT(*) as slot, date_appoint FROM appointments a where a.customer_id <> '' and a.service = 1 group by date_appoint");

        return ['open_slot' => $open, 'close_slot' => $closed];
    }

    public function deleteService(Request $request)
    {
        Service::destroy($request->id);

        return ['success' => 'Service has been deleted!'];
    }

    public function deleteSchedule(Request $request)
    {
        Appointment::destroy($request->id);

        return ['success' => 'Appointment has been deleted!'];
    }
}
