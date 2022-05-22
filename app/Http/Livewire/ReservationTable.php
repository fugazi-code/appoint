<?php

namespace App\Http\Livewire;

use App\Models\Reservation;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ReservationTable extends DataTableComponent
{
    protected $model = Reservation::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Service", "serviced.name")
                ->sortable(),
            Column::make("Date appoint", "date_appoint")
                ->sortable(),
            Column::make("Slots", "slots")
                ->sortable(),
            Column::make("Slots", "slots")
                ->sortable()
                ->format(
                    function ($value, $row, Column $column) {
                        return '
                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                          <button type="button"
                           class="btn btn-info"
                           data-toggle="modal"
                           data-target="#exampleModal"
                          wire:click="$emit(\'bindEditReserve\', '.$row['id'].')">Edit</button>
                          <button type="button"
                          class="btn btn-danger"
                          wire:click="delete('.$row['id'].')">Delete</button>
                        </div>';
                    }
                )
                ->html(),
//            Column::make("Created at", "created_at")
//                ->sortable(),
//            Column::make("Updated at", "updated_at")
//                ->sortable(),
        ];
    }

    public function delete($id)
    {
        Reservation::destroy($id);
    }
}
