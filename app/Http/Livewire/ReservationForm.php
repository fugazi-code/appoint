<?php

namespace App\Http\Livewire;

use App\Models\Reservation;
use App\Models\Service;
use Livewire\Component;

class ReservationForm extends Component
{
    public $services;
    public $serviceId;
    public $dateAppoint;
    public $slot;

    public function mount()
    {
        $this->services = Service::all()->toArray();
        $this->resetValues();
    }

    public function render()
    {
        return view('livewire.reservation-form');
    }

    public function resetValues()
    {
        $this->serviceId = '';
        $this->dateAppoint = now()->format('Y-m-d');
        $this->slot = 0;
    }

    public function storeReserve()
    {
        Reservation::create([
            'service' => $this->serviceId,
            'date_appoint' => $this->dateAppoint,
            'slots' => $this->slot,
        ]);
        $this->emit('refreshDatatable');
    }
}
