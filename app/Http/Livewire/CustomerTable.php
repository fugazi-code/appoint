<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Customer;

class CustomerTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Customer::query()->with(['serviceHasOne']);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Service id", "serviceHasOne.name")
                ->searchable()
                ->sortable(),
            Column::make("Name", "name")
                ->searchable()
                ->sortable(),
            Column::make("Phone", "phone")
                ->sortable(),
            Column::make("Email", "email")
                ->searchable()
                ->sortable(),
            Column::make("Is verified", "is_verified")
                ->searchable()
                ->sortable(),
            Column::make("Created At", "created_at")
                ->format(
                    fn($value, $row, Column $column) => Carbon::parse($row->created_at)->format("F j, Y H:i A")
                )
                ->sortable(),
            Column::make("Ip address", "ip_address")
                ->sortable(),
        ];
    }
}
