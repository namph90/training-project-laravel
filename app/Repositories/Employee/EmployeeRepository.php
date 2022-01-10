<?php

namespace App\Repositories\Employee;

use App\Repositories\BaseRepository;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Employee::class;
    }

    public function getEmployee()
    {
        return $this->model->select('first_name', 'email', 'id')->get();
    }
}
