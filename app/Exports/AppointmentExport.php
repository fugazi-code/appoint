<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class AppointmentExport implements FromCollection, WithHeadings, WithColumnWidths
{
    public $dated;

    public $service;

    public $service_name;

    public function __construct($dated, $service, $service_name)
    {
        $this->service      = $service;
        $this->dated        = $dated;
        $this->service_name = $service_name;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $no     = 0;
        $result = Appointment::query()
                             ->where('service', $this->service)
                             ->where('date_appoint', $this->dated)
                             ->where('customer_id', '<>', '')
                             ->with(['hasOneCustomer', 'hasOneService'])
                             ->orderBy('time_appoint')
                             ->get()
                             ->transform(function ($value) use ($no) {
                                 return [
                                     'no'            => ++$no,
                                     'customer_name' => $value['hasOneCustomer']['name'],
                                     'service'       => $value['hasOneService']['name'],
                                     'date_appoint'  => Carbon::parse($value['date_appoint'])->format('F j, Y'),
                                     'time_appoint'  => Carbon::parse($value['time_appoint'])->format('h:m A'),
                                     'is_verified'   => $value['hasOneCustomer']['is_verified'],
                                 ];
                             });

        return $result;
    }

    public function headings(): array
    {
        return [
            ["{$this->service_name} Appointment Details for " . Carbon::parse($this->dated)->format('F j, Y')],
            [],
            [
                'Record No#',
                'Customer Name',
                'Category',
                'Date',
                'Time',
                'Code',
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,
            'C' => 25,
            'D' => 20,
            'E' => 20,
            'F' => 20,
        ];
    }
}
