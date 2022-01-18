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
        $resul = $this->model->sortable(['id' => 'desc']);
        if(request()->get('name')) {
            $resul->search_name(request()->get('name'));
        }
        if(request()->get('email')) {
            $resul->search_email(request()->get('email'));
        }
        if(request()->get('team')) {
            $resul->search_team(request()->get('team'));
        }
        return $resul->paginate(config('const.record_perpage_paging'));
    }
}
