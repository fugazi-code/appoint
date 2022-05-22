<?php

namespace App\Http\Livewire;

use App\Models\Reservation;
use App\Models\Service;
use Livewire\Component;

class ReservationForm extends Component
{
    public    $services;
    public    $reserveId;
    public    $serviceId;
    public    $dateAppoint;
    public    $slot;
    protected $listeners = ['bindEditReserve' => 'bindEdit'];

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
        $this->serviceId   = '';
        $this->dateAppoint = now()->format('Y-m-d');
        $this->slot        = 0;
        $this->reserveId   = null;
    }

    public function storeReserve()
    {
        Reservation::query()->updateOrCreate(['id' => $this->reserveId],
            [
                'service'      => $this->serviceId,
                'date_appoint' => $this->dateAppoint,
                'slots'        => $this->slot,
            ]);
        $this->emit('refreshDatatable');
    }

    public function bindEdit($params)
    {
        $this->resetValues();
        $model             = Reservation::query()->findOrFail($params);
        $this->serviceId   = $model->service;
        $this->dateAppoint = $model->date_appoint;
        $this->slot      = $model->slots;
        $this->reserveId   = $model->id;
    }
}
