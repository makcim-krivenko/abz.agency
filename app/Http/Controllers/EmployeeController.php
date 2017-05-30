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
     * Folder with avatars
     *
     * @var string
     */
    const AVATAR_PATH = 'avatars';

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
            'boss'      => 'required|integer',
            'avatar'    => 'image|between:50, 10000|mimes:jpeg'
        ]);

        $position = Position::where('name', $request->position)->first();
        if (!isset($position->id)) {
            return redirect('/employees/create')
                ->withErrors(['save_error' => 'Such a position does not exist'])
                ->withInput();
        }

        $boss = Employee::find($request->boss);
        if (!isset($boss->id)) {
            return redirect('/employees/create')
                ->withErrors(['save_error' => 'Such a boss does not exist'])
                ->withInput();
        }

        $employee = new Employee();
        $employee->position_id = $position->id;
        $employee->full_name   = $request->full_name;
        $employee->work_from   = $request->work_from;
        $employee->salary      = $request->salary;
        $employee->parent_id   = $request->boss;
        if (!$employee->save()) {
            return redirect('/employees/create')
                ->withErrors(['save_error' => 'Error saving employee'])
                ->withInput();
        }

        $request->file('avatar')->move(storage_path(static::AVATAR_PATH) . $employee->id . 'jpg');

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
            'boss'      => 'required|integer',
            'avatar'    => 'image|between:50, 10000|mimes:jpeg'
        ]);

        $employee  = Employee::find($id);
        if (!isset($employee->id)) {
            return redirect('/employees/')
                ->withErrors(['isset_error' => 'Such employee does not exist'])
                ->withInput();
        }

        $position = Position::where('name', $request->position)->first();
        if (!isset($position->id)) {
            return redirect('/employees/')
                ->withErrors(['isset_error' => 'Such a position does not exist'])
                ->withInput();
        }

        $boss = Employee::find($request->boss);
        if (!isset($boss->id) && $request->boss != 0) {
            return redirect('/employees/')
                ->withErrors(['save_error' => 'Such a boss does not exist'])
                ->withInput();
        }

        if ($request->boss != 0 && $boss->id == $employee->id) {
            return redirect('/employees/')
                ->withErrors(['save_error' => 'Incorrect boss'])
                ->withInput();
        }

        $employee->position_id = $position->id;
        $employee->full_name   = $request->full_name;
        $employee->work_from   = $request->work_from;
        $employee->salary      = $request->salary;
        $employee->parent_id   = $request->boss;
        $employee->updated_at  = Carbon::now();

        if (!$employee->save()) {
            return redirect('/employees/')
                ->withErrors(['isset_error' => 'Error saving employee'])
                ->withInput();
        }

        if (isset($request->avatar)) {
            $request->avatar->storeAs(static::AVATAR_PATH, $employee->id . '.jpg');
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

    public function search(Request $request)
    {
        $employeers = Employee::where('full_name', 'like', '%' . $request->q . '%')->get(['id', 'full_name']);

        return json_encode(['items' => $employeers->toArray()]);
    }

    public function tree()
    {
        return view('employees.tree');
    }

    public function getTree(Request $request)
    {
        $res      = [];

        if (isset($request->node)) {
            $employee = Employee::find($request->node);
            if (isset($employee->id)) {
                $subordinates = Employee::where('parent_id', $employee->id)->get();
                if ($subordinates->count() >0) {
                    foreach ($subordinates as $key => $subordinate) {
                        $count = Employee::where('parent_id', $subordinate->id)->count();
                        $res[$key]['id']             = $subordinate->id;
                        $res[$key]['label']          = $subordinate->full_name;
                        $res[$key]['position']       = $subordinate->position->name;
                        $res[$key]['load_on_demand'] = $count ? true : false;
                    }
                }
            }
        } else {
            $employee = Employee::where('parent_id', 0)->first();
            $res[0]['id']             = $employee->id;
            $res[0]['label']          = $employee->full_name;
            $res[0]['position']       = $employee->position->name;
            $res[0]['load_on_demand'] = true;
        }

        return json_encode($res);
    }
}
