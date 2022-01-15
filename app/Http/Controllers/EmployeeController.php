<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\CreateRequest;
use App\Http\Requests\Employee\EditRequest;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\Team\TeamRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request;

class EmployeeController extends Controller
{
    protected $employeeRepo;
    protected $teamRepo;

    /**
     * EmployeeController constructor.
     * @param EmployeeRepositoryInterface $employeeRepo
     * @param TeamRepositoryInterface $teamRepo
     */
    public function __construct(EmployeeRepositoryInterface $employeeRepo, TeamRepositoryInterface $teamRepo)
    {
        $this->employeeRepo = $employeeRepo;
        $this->teamRepo = $teamRepo;
    }

    public function show()
    {
        $teams = $this->teamRepo->getAll();
        $data = $this->employeeRepo->search();
        return view('employees.search', ['data' => $data, 'teams' => $teams]);
    }

    public function create()
    {
        if(!session()->has('token')){
            session()->forget(['url_img', 'tmp_url']);
        }
        $teams = $this->teamRepo->getAll();
        return view('employees.create', ['teams' => $teams]);
    }

    public function createConfirm(CreateRequest $request)
    {
        $data = session('data_confirm');
        $teams = $this->teamRepo->getAll();
        Session::flash('employee_create', $data);
        return view('employees.create_confirm', ['data' => $data, 'teams' => $teams]);
    }

    public function store()
    {
        //$data = Arr::except(session('employee_store'), ['_token', 'src_img', 'tmp_url']);
        $data = session('employee_store');
        $result = $this->employeeRepo->create($data);
        $id = $result->id;
        if ($result) {
            Storage::move('public/tmp/' . $data['avatar'], 'public/uploads/' . $id . '/' . $data['avatar']);
            Storage::deleteDirectory('public/tmp', 'public/uploads');
            session()->forget('check_avatar');
            return redirect()->route('employee.search')->with('success', 'Create Successfull!');
        } else {
            return view('elements.error');
        }
    }

    public function edit($id)
    {
        if(!session()->has('token')){
            session()->forget(['img_avatar', 'tmp_url', 'data_confirm_edit']);
        }
        $teams = $this->teamRepo->getAll();
        //$employee = $this->employeeRepo->find($id);
        session()->put('old_data', $this->employeeRepo->find($id));
        return view('employees.edit', ['employee' => session('old_data'), 'teams' => $teams]);
    }

    public function editConfirm(EditRequest $request, $id)
    {
        $data = session('data_confirm_edit');
        Session::flash('employee_edit', $data);
        $teams = $this->teamRepo->getAll();
        return view('employees.edit_confirm', ['data' => $data, 'id'=>$id, 'teams' => $teams]);
    }

    public function update($id)
    {
        $data = session('data_confirm_edit');
        $result =  $this->employeeRepo->update($id, $data);
        if ($result) {
            if(session()->has('tmp_url')){
                Storage::deleteDirectory('public/uploads/' . $id);
                Storage::move('public/tmp/' . $data['avatar'], 'public/uploads/' . $id . '/' . $data['avatar']);
                Storage::deleteDirectory('public/tmp', 'public/uploads');
            }
            session()->forget('data_confirm_edit');
            return redirect()->route('employee.search')->with('success', 'Update Successfull!');
        } else {
            return view('elements.error');
        }
    }

    public function destroy($id)
    {
        $result = $this->employeeRepo->delete($id);
        if ($result) {
            return redirect()->route('employee.search')->with('success', 'Delete Successfull!');
        } else {
            return view('elements.error');
        }
    }

    public function home()
    {
        return view('elements.home');
    }
}
