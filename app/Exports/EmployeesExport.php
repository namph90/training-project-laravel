<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class EmployeesExport implements FromCollection, WithHeadings, WithColumnWidths
{

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Team',
            'Name',
            'Email'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 55,
            'B' => 70,
            'C' => 200,
            'D' => 200,
        ];
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return collect($this->data);
    }

}
