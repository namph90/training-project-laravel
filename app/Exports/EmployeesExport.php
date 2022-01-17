<?php

namespace App\Exports;

use App\Models\Employee;
use App\Repositories\Employee\EmployeeRepository;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Arr;

class EmployeesExport implements FromCollection, WithHeadings
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

    /**
    * @return Collection
    */
    public function collection()
    {
        return collect($this->data);
    }
}
