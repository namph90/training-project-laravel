<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use App\Http\Requests\Employee\CreateRequest;
use App\Http\Requests\Employee\EditRequest;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\Team\TeamRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
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
        $this->employeeRepo = $employeeRepo;
        $this->teamRepo = $teamRepo;
        $this->sendEmail = $sendEmail;
    }

    public function show()
    {
        $teams = $this->teamRepo->getAll();
        $data = $this->employeeRepo->search();

        session()->put('exportCSV', $data);
        return view('employees.search', ['data' => $data, 'teams' => $teams]);
    }

    public function create()
    {
        if (!session()->has('token')) {
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
        $data = session('employee_store');
        $result = $this->employeeRepo->create($data);
        $id = $result->id;

        if ($result) {
            Storage::move(config('const.TEMP_DIR') . $data['avatar'], config('const.PATH_UPLOAD') . $id . '/' . $data['avatar']);
            Storage::deleteDirectory(config('const.TEMP_DIR'), config('const.PATH_UPLOAD'));

            $this->sendEmail->send($result);
            return redirect()->route('employee.search')->with('success', trans('messages.create_success'));
        } else {
            return view('elements.error');
        }
    }

    public function edit($id)
    {
        if (!session()->has('token')) {
            session()->forget(['img_avatar', 'tmp_url', 'data_confirm_edit']);
        }

        $teams = $this->teamRepo->getAll();
        session()->put('old_data', $this->employeeRepo->find($id));

        return view('employees.edit', ['employee' => session('old_data'), 'teams' => $teams]);
    }

    public function editConfirm(EditRequest $request, $id)
    {
        $data = session('data_confirm_edit');
        Session::flash('employee_edit', $data);

        $teams = $this->teamRepo->getAll();
        return view('employees.edit_confirm', ['data' => $data, 'id' => $id, 'teams' => $teams]);
    }

    public function update($id)
    {
        $data = session('data_confirm_edit');
        $result = $this->employeeRepo->update($id, $data);

        if ($result) {
            if (session()->has('tmp_url')) {
                Storage::deleteDirectory(config('const.PATH_UPLOAD') . $id);
                Storage::move(config('const.TEMP_DIR') . $data['avatar'], config('const.PATH_UPLOAD') . $id . '/' . $data['avatar']);
                Storage::deleteDirectory(config('const.TEMP_DIR'), config('const.PATH_UPLOAD'));
            }

            if (session('old_data')->email != $data['email']) {
                $dataSendEmail = $this->employeeRepo->find($id);
                $this->sendEmail->send($dataSendEmail);
            }

            return redirect()->route('employee.search')->with('success', trans('messages.update_success'));
        } else {
            return view('elements.error');
        }
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
            return view('elements.error');
        }
    }

    public function home()
    {
        return view('elements.home');
    }

    public function export()
    {
        foreach (session('exportCSV') as $key => $employee) {
            $employees[$key] = [
                'id' => $employee->id,
                'team' => $employee->team->name,
                'name' => $employee->name,
                'email' => $employee->email,
            ];
        }

        return Excel::download(new EmployeesExport($employees), 'fileEmployee.csv');
    }
}
