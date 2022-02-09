<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use App\Http\Requests\Employee\CreateRequest;
use App\Http\Requests\Employee\EditRequest;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\Team\TeamRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
        $teams = $this->teamRepo->getAll();
        $data = $this->employeeRepo->search();

        $this->setFormData($data);
        $this->getFormData();
        return view('employees.search', ['data' => $data, 'teams' => $teams]);
    }

    public function create()
    {
        if (!session()->has('token')) {
            session()->forget(['url_img', 'tmp_url', 'employee_createConfirm']);
        }

        $teams = $this->teamRepo->getAll();
        return view('employees.create', ['teams' => $teams]);
    }

    public function createConfirm(CreateRequest $request)
    {
        $data = array_merge(request()->all(), session('img_avatar'));

        $this->setFormData($data);
        $this->getFormData(true);

        $teams = $this->teamRepo->getAll();
        return view('employees.create_confirm', ['data' => $data, 'teams' => $teams]);
    }

    public function store()
    {
        $data = $this->getFormData();
        try {
            $result = $this->employeeRepo->create($data);
            if ($result) {
                $id = $result->id;
                Storage::move(config('const.TEMP_DIR') . $data['avatar'], config('const.PATH_UPLOAD') . $id . '/' . $data['avatar']);
                Storage::deleteDirectory(config('const.TEMP_DIR'), config('const.PATH_UPLOAD'));

                $this->sendEmail->send($result);
            }
            session()->flash('success', __('messages.create_success'));

        } catch (\Exception $e) {
            Log::info('Employee Store Error ', ['ins_id' => Auth::id()]);
            session()->flash('error', __('messages.create_fail'));
        }
        return redirect()->route('employee.search');
    }

    public function edit($id)
    {
        if (!session()->has('token')) {
            session()->forget(['img_avatar', 'tmp_url', 'employee_editConfirm']);
        }

        $teams = $this->teamRepo->getAll();
        $this->setFormData($this->employeeRepo->find($id));
        $employee = $this->getFormData();
        return view('employees.edit', ['employee' => $employee, 'teams' => $teams]);
    }

    public function editConfirm(EditRequest $request, $id)
    {
        $data = array_merge(request()->all(), session('img_avatar'));

        $this->setFormData($data);
        $this->getFormData(true);

        $teams = $this->teamRepo->getAll();
        return view('employees.edit_confirm', ['data' => $data, 'id' => $id, 'teams' => $teams]);
    }

    public function update($id)
    {
        try {
            $data = session('employee_editConfirm');
            if (empty($data['password'])) {
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
            session()->flash('success', __('messages.update_success'));

        } catch (\Exception $e) {
            Log::info('Employee Update Error ', ['ins_id' => Auth::id()]);
            session()->flash('error', __('messages.update_fail'));
        }
        return redirect()->route('employee.search');
    }

    public function destroy($id)
    {
        try {
            $result = $this->employeeRepo->delete($id);

            if ($result) {
                Storage::deleteDirectory(config('const.PATH_UPLOAD') . $id);

                return redirect()->route('employee.search')->with('success', trans('messages.delete_success'));
            }
        } catch (\Exception $e) {
            Log::info('Employee Delete Error ', ['ins_id' => Auth::id()]);
            session()->flash('error', __('messages.delete_fail'));
        }
        return redirect()->route('employee.search');
    }

    public function home()
    {
        return view('elements.home');
    }

    public function export()
    {
        foreach (session('employee_show') as $key => $employee) {
            $employees[$key] = [
                'id' => $employee->id,
                'team' => $employee->team->name,
                'name' => $employee->full_name,
                'email' => $employee->email,
            ];
        }

        return Excel::download(new EmployeesExport($employees), 'fileEmployee.csv');
    }
}
