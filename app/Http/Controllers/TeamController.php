<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teams\CreateRequest;
use App\Repositories\Team\TeamRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
        $data = $this->teamRepo->search();
        return view('teams.search', ['data' => $data]);
    }

    public function create()
    {
        if (session()->has('team_returnBack')) {
            session()->forget('team_createConfirm');
        }
        return view('teams.create');
    }

    public function createConfirm(CreateRequest $request)
    {
        $this->setFormData(request()->all());
        $data = $this->getFormData();
        $this->getFormData(true);

        return view('teams.create_confirm', ['data' => $data]);

    }

    public function store()
    {
        try {
            $data = request()->all();
            $this->teamRepo->create($data);
            session()->flash('success', __('messages.create_success'));

        } catch (\Exception $e) {
            Log::info('Team Store Error ', ['ins_id' => Auth::id()]);
            session()->flash('error', __('messages.create_fail'));
        }
        return redirect()->route('team.search');

    }

    public function edit($id)
    {
        $team = $this->teamRepo->find($id);
        return view('teams.edit', ['team' => $team]);
    }

    public function editConfirm(CreateRequest $request, $id)
    {
        $data = request()->all();
        $this->setFormData($data);
        $this->getFormData(true);
        return view('teams.edit_confirm', ['data' => $data, 'id' => $id]);

    }

    public function update($id)
    {
        try {
            $data = request()->all();
            $this->teamRepo->update($id, $data);
            session()->flash('success', __('messages.update_success'));

        } catch (\Exception $e) {
            Log::info('Team Update Error ', ['ins_id' => Auth::id()]);
            session()->flash('error', __('messages.update_fail'));
        }
        return redirect()->route('team.search');
    }

    public function destroy($id)
    {
        try {
            $team = $this->teamRepo->find($id);

            if ($team->employees->count() == 0) {
                $this->teamRepo->delete($id);
                Session::flash('success', __('messages.delete_success'));

            } else {
                Session::flash('error', __('messages.delete_employee_fail'));
            }
        } catch (\Exception $e) {
            Log::info('Team Delete Error ', ['ins_id' => Auth::id()]);
            session()->flash('error', __('messages.delete_fail'));
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
