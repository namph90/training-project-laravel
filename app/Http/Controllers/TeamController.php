<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teams\CreateRequest;
use App\Repositories\Team\TeamRepositoryInterface;
use Illuminate\Support\Facades\Session;

class TeamController extends BaseController
{
    protected $teamRepo;

    /**
     * EmployeeController constructor.
     * @param TeamRepositoryInterface $teamRepo
     */
    public function __construct(TeamRepositoryInterface $teamRepo)
    {
        parent::__construct();
        $this->setSession('team');
        $this->teamRepo = $teamRepo;
    }

    public function show()
    {
        try {
            $data = $this->teamRepo->search();
            return view('teams.search', ['data' => $data]);

        } catch(\Exception $e){
            return abort(500);
        }

    }

    public function create()
    {
        try {
            if (session()->has('team_returnBack')) {
                session()->forget('team_createConfirm');
            }
            return view('teams.create');

        } catch(\Exception $e){
            return abort(500);
        }

    }

    public function createConfirm(CreateRequest $request)
    {
        try {
            $this->setFormData(request()->all());
            $data = $this->getFormData();
            $this->getFormData(true);

            return view('teams.create_confirm', ['data' => $data]);

        } catch(\Exception $e){
            return abort(500);
        }

    }

    public function store()
    {
        $data = request()->except('_token');
        $this->teamRepo->create($data);
        return redirect()->route('team.search');
    }

    public function edit($id)
    {
        try {
            $team = $this->teamRepo->find($id);
            return view('teams.edit', ['team' => $team]);

        } catch(\Exception $e){
            return abort(500);
        }

    }

    public function editConfirm(CreateRequest $request, $id)
    {
        try {
            $data = request()->all();
            $this->setFormData($data);
            $this->getFormData(true);
            return view('teams.edit_confirm', ['data' => $data, 'id' => $id]);

        } catch(\Exception $e){
            return abort(500);
        }
    }

    public function update($id)
    {
        $data = request()->except('_token', '_method');
        $this->teamRepo->update($id, $data);
        return redirect()->route('team.search');
    }

    public function destroy($id)
    {
        $team = $this->teamRepo->find($id);

        if ($team->employees->count() == 0) {
            $this->teamRepo->delete($id);
            Session::flash('success', __('messages.delete_success'));

        } else {
            Session::flash('error', __('messages.delete_fail'));

        }

        return redirect()->route('team.search');
    }

    public function returnBack()
    {
        $this->setFormData(array());
        $this->setFormData(true);
        return view('teams.create');
    }

}
