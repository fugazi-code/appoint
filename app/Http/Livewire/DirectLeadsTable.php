<?php

namespace App\Http\Livewire;

use App\Models\Leads;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DirectLeadsTable extends DataTableComponent
{
    protected $model = Leads::class;

    public array $bulkActions = [
        'exportSelected' => 'Export',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('id', 'desc')
            ->setTableWrapperAttributes(['style' => 'overflow-x:auto;'])
            ->setTdAttributes(fn() =>['class' => 'bg-gray-100', 'style' => 'white-space: nowrap;'])
            ->setThAttributes(fn() =>['class' => 'bg-gray-100', 'style' => 'white-space: nowrap;']);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("E-mail", "email")
                ->sortable(),
            Column::make("Name", "customer.name")
                ->sortable(),
            Column::make("Phone", "customer.phone")
                ->sortable(),
            Column::make("IP Address", "customer.ip_address")
                ->sortable(),
            Column::make("Other Details", "customer.other_details")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable()
        ];
    }

    public function exportSelected()
    {
        foreach ($this->getSelected() as $item) {
            dump($item);
        }
    }
}
