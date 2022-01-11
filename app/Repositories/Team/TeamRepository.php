<?php

namespace App\Repositories\Team;

use App\Repositories\BaseRepository;
use App\Scopes\AncientScope;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Team::class;
    }

    public function getDelete()
    {
        return $this->model->withoutGlobalScope(AncientScope::class)->get();
    }
//    public function getTest()
//    {
//        return $this->model->active()->get();
//    }

    public function search()
    {
        return $this->model->paginate(3);
    }
}
