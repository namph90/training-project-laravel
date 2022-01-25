<?php

namespace App\Repositories\Employee;

use App\Repositories\BaseRepository;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Employee::class;
    }

    public function search()
    {
        $resul = $this->model->select('id', 'team_id', 'avatar', 'first_name', 'last_name', 'email')->sortable(['id' => 'desc']);
        if (request()->get('name')) {
            $resul->where('last_name', 'like', '%' . request()->get('name') . '%');
        }
        if (request()->get('email')) {
            $resul->where('email', 'like', '%' . request()->get('email') . '%');
        }
        if (request()->get('team')) {
            $resul->where('team_id', '=', request()->get('team'));
        }
        return $resul->paginate(config('const.record_perpage_paging'));
    }
}
