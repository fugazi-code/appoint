<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Leads;
use Livewire\Component;

class DirectLeads extends Component
{
    public function render()
    {
        return view('livewire.direct-leads')->layout('layouts.livewired');
    }

    public function reSync()
    {
        foreach (Customer::query()->select(['email', 'id'])->orderBy('id')->cursor() as $value) {
            if(Leads::query()->where('email', $value->email)->doesntExist())
            {
                Leads::query()->create([
                    'customer_id' => $value->id,
                    'email' => $value->email,
                ]);
            }
        }

        $this->emit('refreshDatatable');
    }
}
