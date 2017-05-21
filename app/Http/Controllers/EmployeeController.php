<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Position;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    const PER_PAGE = 12;

    /**
     * Display a listing of the employees.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::paginate(static::PER_PAGE);

        return view('employees.employees', ['employees' => $employees]);
    }

    /**
     * Display Add New Employee form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $positions = Position::where('name', '!=', 'Big Boss')->get();

        return view('employees.create', ['positions' => $positions]);
    }

    /*
     * Create new employee
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required|max:100',
            'work_from' => 'required|date',
            'salary'    => 'required|integer',
            'position'  => 'required|max:255',
        ]);

        $position = Position::where('name', $request->position)->first();
        if (!isset($position->id)) {
            return redirect('/employees/create')
                ->withErrors(['save_error' => 'Such a position does not exist'])
                ->withInput();
        }

        $employee = new Employee();
        $employee->position_id = $position->id;
        $employee->full_name   = $request->full_name;
        $employee->work_from   = $request->work_from;
        $employee->salary      = $request->salary;
        if (!$employee->save()) {
            return redirect('/employees/create')
                ->withErrors(['save_error' => 'Error saving employee'])
                ->withInput();
        }

        return redirect('/employees/');
    }

    /**
     * Show the form for editing employee.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $positions = Position::all();
        $employee  = Employee::find($id);
        if (!isset($employee->id)) {
            return redirect('/employees/')
                ->withErrors(['isset_error' => 'Such employee does not exist'])
                ->withInput();
        }

        return view('employees.edit', ['employee' => $employee, 'positions' => $positions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'full_name' => 'required|max:100',
            'work_from' => 'required|date',
            'salary'    => 'required|integer',
            'position'  => 'required|max:255',
        ]);

        $employee  = Employee::find($id);
        if (!isset($employee->id)) {
            return redirect('/employees/')
                ->withErrors(['isset_error' => 'Such employee does not exist'])
                ->withInput();
        }

        $position = Position::where('name', $request->position)->first();
        if (!isset($position->id)) {
            return redirect('/employees/create')
                ->withErrors(['isset_error' => 'Such a position does not exist'])
                ->withInput();
        }

        $employee->position_id = $position->id;
        $employee->full_name   = $request->full_name;
        $employee->work_from   = $request->work_from;
        $employee->salary      = $request->salary;
        $employee->updated_at  = Carbon::now();

        if (!$employee->save()) {
            return redirect('/employees/create')
                ->withErrors(['isset_error' => 'Error saving employee'])
                ->withInput();
        }

        return redirect('/employees/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee  = Employee::find($id);
        if (!isset($employee->id)) {
            return redirect('/employees/')
                ->withErrors(['isset_error' => 'Such employee does not exist'])
                ->withInput();
        }

        DB::transaction(function() use ($employee) {
            Employee::where('parent_id', $employee->id)
                    ->update(['parent_id' => $employee->parent_id]);

            $employee->delete();
        } );

        return redirect('/employees/');
    }

    public function welcome()
    {
        return view('welcome');
    }

    protected function getTree($id)
    {
        $res      = [];
        $employee = Employee::find($id);

        if (isset($employee->id)) {
            $subordinates = Employee::where('parent_id', $employee->id)->get();
            $res['id']        = $employee->id;
            $res['full_name'] = $employee->full_name;
            $res['position']  = $employee->position;
            $res['position']  = $subordinates->count();
            if ($subordinates->count() >0) {
                foreach ($subordinates as $key => $subordinate) {
                    $count = Employee::where('parent_id', $subordinate->id)->count();
                    $res['children'][$key]['id']        = $subordinate->id;
                    $res['children'][$key]['full_name'] = $subordinate->full_name;
                    $res['children'][$key]['position']  = $subordinate->position->name;
                    $res['children'][$key]['count']     = $count;
                }
            }
        }

        return $res;
    }
}
