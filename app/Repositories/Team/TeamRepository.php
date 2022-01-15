<?php

namespace App\Repositories\Team;

use App\Models\Team;
use App\Repositories\BaseRepository;
use App\Scopes\AncientScope;


class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Team::class;
    }

//    public function getDelete()
//    {
//        return $this->model->withoutGlobalScope(AncientScope::class)->get();
//    }

    public function search()
    {
        $resul = $this->model->sortable(['id' => 'desc']);
        if(request()->get('searchName')) {
            $resul->search_name(request()->get('searchName'));
        }
        return $resul->paginate(3);
    }
}
