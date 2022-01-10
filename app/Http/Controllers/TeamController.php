<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teams\CreateRequest;
use App\Repositories\Team\TeamRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Team;

class TeamController extends Controller
{
    protected $teamRepo;

    /**
     * EmployeeController constructor.
     * @param TeamRepositoryInterface $teamRepo
     */
    public function __construct(TeamRepositoryInterface $teamRepo)
    {
        $this->teamRepo = $teamRepo;
    }

    public function index()
    {
        return view('teams.search');
    }

    public function create()
    {
        return view('teams.create');
    }

    public function confirm(CreateRequest $request)
    {
        $data = request()->all();
        Session::flash('value', $data['name']);
        return view('teams.confirm', ['data'=>$data]);
    }

    public function store()
    {
        $data = request()->all();
        $result = $this->teamRepo->create($data);
        if($result){
            return redirect()->route('team.search')->with('create_success','');
        } else {
            return view('elements.error');
        }

    }
}
