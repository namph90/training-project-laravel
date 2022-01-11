<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teams\CreateRequest;
use App\Repositories\Team\TeamRepositoryInterface;
use Illuminate\Support\Facades\Session;

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
//        $a = $this->teamRepo->getAll();
//        $b = $this->teamRepo->getDelete();
//        $c = $this->teamRepo->getTest();
//        //$data = Team::getGlobalScope('ancient')->get();
        $data = $this->teamRepo->search();
        return view('teams.search', ['data' => $data]);
    }

    public function create()
    {
        return view('teams.create');
    }

    public function createConfirm(CreateRequest $request)
    {
        $data = request()->all();
        Session::flash('value', $data['name']);
        return view('teams.create_confirm', ['data' => $data]);
    }

    public function store()
    {
        $data = request()->all();
        $result = $this->teamRepo->create($data);
        if ($result) {
            return redirect()->route('team.search')->with('create_success', '');
        } else {
            return view('elements.error');
        }
    }

    public function edit($id)
    {
        $team = $this->teamRepo->find($id);
        return view('teams.edit', ['team'=>$team]);
    }

    public function editConfirm(CreateRequest $request, $team)
    {
        $data = request()->all();
        Session::flash('value_edit', $data['name']);
        return view('teams.edit_confirm', ['data' => $data, 'id'=>$team]);
    }

    public function update(CreateRequest $request, $id)
    {
        //
    }
}
