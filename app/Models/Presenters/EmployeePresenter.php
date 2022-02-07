<?php

namespace App\Models\Presenters;

trait EmployeePresenter
{
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
