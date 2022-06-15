<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Customer;

class CustomerTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Customer::query()
            ->with(['serviceHasOne', 'appointmentHasOne']);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Service", "serviceHasOne.name")
                ->searchable()
                ->sortable(),
            Column::make("Appoint ID", "appointmentHasOne.id")
                ->searchable()
                ->sortable(),
            Column::make("Appoint Date", "appointmentHasOne.date_appoint")
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
                ->format(
                    fn($value, $row, Column $column) => "<a href='#' class='btn btn-sm btn-info' wire:click='randThis({$row->id})'>*</a> {$row->is_verified}"
                )
                ->html()
                ->searchable()
                ->sortable(),
            Column::make("Created At", "created_at")
                ->format(
                    fn($value, $row, Column $column) => Carbon::parse($row->created_at)->format("F j, Y h:i:s A")
                )
                ->sortable(),
            Column::make("Ip address", "ip_address")
                ->sortable(),
            Column::make("Updated At", "updated_at")
                ->format(
                    fn($value, $row, Column $column) => Carbon::parse($row->updated_at)->format("F j, Y h:i:s A")
                )
                ->sortable(),
        ];
    }

    public function randThis($id)
    {
        $faker = Factory::create();
        Customer::query()->where('id', $id)->update(['is_verified' => $faker->hexColor]);
    }
}
