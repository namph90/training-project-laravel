<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use App\Http\Requests\Employee\CreateRequest;
use App\Http\Requests\Employee\EditRequest;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\Team\TeamRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;

class EmployeeController extends BaseController
{
    protected $employeeRepo;
    protected $teamRepo;
    protected $sendEmail;

    /**
     * EmployeeController constructor.
     * @param EmployeeRepositoryInterface $employeeRepo
     * @param TeamRepositoryInterface $teamRepo
     * @param SendEmailController $sendEmail
     */
    public function __construct(EmployeeRepositoryInterface $employeeRepo, TeamRepositoryInterface $teamRepo, SendEmailController $sendEmail)
    {
        parent::__construct();
        $this->setSession('employee');
        $this->employeeRepo = $employeeRepo;
        $this->teamRepo = $teamRepo;
        $this->sendEmail = $sendEmail;
    }

    public function show()
    {
        try {
            $teams = $this->teamRepo->getAll();
            $data = $this->employeeRepo->search();

            $this->setFormData($data);
            $this->getFormData();
            return view('employees.search', ['data' => $data, 'teams' => $teams]);

        } catch(\Exception $e){
            return abort(500);
        }
    }

    public function create()
    {
        try {
            if (!session()->has('token')) {
                session()->forget(['url_img', 'tmp_url', 'employee_createConfirm']);
            }

            $teams = $this->teamRepo->getAll();
            return view('employees.create', ['teams' => $teams]);

        } catch(\Exception $e){
            return abort(500);
        }
    }

    public function createConfirm(CreateRequest $request)
    {
        try {
            $data = array_merge(request()->all(), session('img_avatar'));

            $this->setFormData($data);
            $this->getFormData(true);

            $teams = $this->teamRepo->getAll();
            return view('employees.create_confirm', ['data' => $data, 'teams' => $teams]);

        } catch(\Exception $e){
            return abort(500);
        }
    }

    public function store()
    {
        $data = Arr::except($this->getFormData(), ['src_img', '_token', 'tmp_url', 'password_confirm']);
        $result = $this->employeeRepo->create($data);

        if ($result) {
            $id = $result->id;
            Storage::move(config('const.TEMP_DIR') . $data['avatar'], config('const.PATH_UPLOAD') . $id . '/' . $data['avatar']);
            Storage::deleteDirectory(config('const.TEMP_DIR'), config('const.PATH_UPLOAD'));

            $this->sendEmail->send($result);
        }
        return redirect()->route('employee.search');
    }

    public function edit($id)
    {
        try {
            if (!session()->has('token')) {
                session()->forget(['img_avatar', 'tmp_url', 'employee_editConfirm']);
            }

            $teams = $this->teamRepo->getAll();
            $this->setFormData($this->employeeRepo->find($id));
            $employee = $this->getFormData();
            return view('employees.edit', ['employee' => $employee, 'teams' => $teams]);

        } catch(\Exception $e){
            return abort(500);
        }
    }

    public function editConfirm(EditRequest $request, $id)
    {
        try {
            $data = array_merge(request()->all(), session('img_avatar'));

            $this->setFormData($data);
            $this->getFormData(true);

            $teams = $this->teamRepo->getAll();
            return view('employees.edit_confirm', ['data' => $data, 'id' => $id, 'teams' => $teams]);

        } catch(\Exception $e){
            return abort(500);
        }
    }

    public function update($id)
    {
        $data = Arr::except(session('employee_editConfirm'), ['src_img', '_token', 'tmp_url', 'password_confirm']);
        if(empty(data_get($data, 'password'))){
            $data = Arr::except($data, ['password']);
        }
        $this->employeeRepo->update($id, $data);

        if (session()->has('tmp_url')) {
            Storage::deleteDirectory(config('const.PATH_UPLOAD') . $id);
            Storage::move(config('const.TEMP_DIR') . $data['avatar'], config('const.PATH_UPLOAD') . $id . '/' . $data['avatar']);
            Storage::deleteDirectory(config('const.TEMP_DIR'), config('const.PATH_UPLOAD'));
        }

        if (session('employee_edit')->email != $data['email']) {
            $dataSendEmail = $this->employeeRepo->find($id);
            $this->sendEmail->send($dataSendEmail);
        }
        return redirect()->route('employee.search');
    }

    public function destroy($id)
    {
        $result = $this->employeeRepo->delete($id);

        if ($result) {
            if (Auth::id() == $id) {
                Auth::logout();
            }

            Storage::deleteDirectory(config('const.PATH_UPLOAD') . $id);

            return redirect()->route('employee.search')->with('success', trans('messages.delete_success'));
        } else {
            return abort(500);
        }
    }

    public function home()
    {
        return view('elements.home');
    }

    public function export()
    {
        try {
            foreach (session('employee_show') as $key => $employee) {
                $employees[$key] = [
                    'id' => $employee->id,
                    'team' => $employee->team->name,
                    'name' => $employee->name,
                    'email' => $employee->email,
                ];
            }

            return Excel::download(new EmployeesExport($employees), 'fileEmployee.csv');

        } catch(\Exception $e){
            return view('elements.error');
        }

    }
}
