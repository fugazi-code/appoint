<?php

namespace App\Http\Livewire;

use App\Mail\NewBookedEmail;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class DirectBooking extends Component
{
    public $services = [];
    public $serviceId = '';
    public $openSlots = [];
    public $appointId = '';
    public $name = '';
    public $email = '';
    public $phone = '';
    public $cr_no = '';
    public $iqama = '';

    public function mount()
    {
        $this->services = Service::all();
    }

    public function render()
    {
        return view('livewire.direct-booking')->layout('layouts.livewired');
    }

    public function updatedServiceId()
    {
        $this->refreshAppointment();
    }

    public function reserve()
    {
        $appointment = Appointment::query()
            ->where('id', $this->appointId)
            ->with(['hasOneService'])
            ->first()
            ->toArray();

        $customer = Customer::create([
            'service_id'    => $appointment['has_one_service']['id'],
            'created_by'    => $appointment['has_one_service']['created_by'],
            'appoint_id'    => $appointment['id'],
            'name'          => $this->name,
            'phone'         => $this->phone,
            'email'         => $this->email,
            'is_verified'   =>  substr(encrypt($this->appointId), -6, -1),
            'other_details' => json_encode(['CR NUMBER' => $this->cr_no, 'IQAMA' => $this->iqama]),
        ]);

        Appointment::query()
            ->where('id', $this->appointId)
            ->where('customer_id', '')
            ->update(['customer_id' => $customer->id]);

        Mail::to([$customer->email])->send(new NewBookedEmail($appointment, $customer));

        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->cr_no = '';
        $this->iqama = '';
        $this->serviceId = '';
        $this->appointId = '';
    }

    public function refreshAppointment()
    {
        $this->openSlots = Appointment::query()
            ->where('date_appoint', '>=', now())
            ->where('service', $this->serviceId)
            ->where('customer_id', '')
            ->get();
    }
}
