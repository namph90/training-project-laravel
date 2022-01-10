<?php

namespace App\Repositories\Team;

use App\Repositories\BaseRepository;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Team::class;
    }

}
