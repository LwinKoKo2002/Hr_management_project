<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Month;
use App\Models\Salary;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreSalaryRequest;
use App\Http\Requests\updateSalaryRequest;
use App\Models\CheckInCheckOut;
use App\Models\CompanySetting;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        return view('salary.index');
    }

    public function datatable()
    {
        $data = Salary::with(['employee','month']);
        return DataTables::of($data)
        ->addColumn('plus-icon', function ($each) {
            return null;
        })
        ->addColumn('employee', function ($each) {
            return $each->employee ? $each->employee->name : '-';
        })
        ->filterColumn('employee', function ($query, $keyword) {
            $query->whereHas('employee', function ($query) use ($keyword) {
                $query->where('name', 'like', '%'.$keyword.'%');
            });
        })
        ->addColumn('month', function ($each) {
            return $each->month ? $each->month->name : '-';
        })
        ->filterColumn('month', function ($query, $keyword) {
            $query->whereHas('month', function ($query) use ($keyword) {
                $query->where('name', 'like', '%'.$keyword.'%');
            });
        })
        ->editColumn('amount', function ($each) {
            return number_format($each->amount);
        })
        ->addColumn('action', function ($each) {
            $edit_icon = '';
            $delete_icon = '';
            $user = User::firstWhere('id', auth()->id());
            if ($user->can('edit_salary')) {
                $edit_icon = '<a href="'.route('salary.edit', $each->id).'" class="edit-icon text-warning"><i class="fa-solid fa-pen-to-square"></i></a>';
            }
            if ($user->can('delete_salary')) {
                $delete_icon = '<a href="" class="info-icon text-danger delete" data-id="'.$each->id.'"><i class="fa-solid fa-trash-can"></i></a>';
            }

            return "<div class='action-icon'>".$edit_icon . $delete_icon ."</div>";
        })
        ->editColumn('updated_at', function ($each) {
            return $each->updated_at->format("d-m-Y H:i:s");
        })
        ->make(true);
    }

    public function create()
    {
        $employees = User::all();
        $months = Month::all();
        return view('salary.create', compact('employees', 'months'));
    }


    public function store(StoreSalaryRequest $request)
    {
        $validated = $request->validated();
        Salary::create($validated);
        return redirect()->route('salary.index')->with(['create'=>'Salary is successfully created.']);
    }


    public function edit(Salary $salary)
    {
        $employees = User::all();
        $months = Month::all();
        return view('salary.edit', compact('employees', 'months', 'salary'));
    }


    public function update(updateSalaryRequest $request, Salary $salary)
    {
        $validated = $request->validated();
        $salary->update($validated);
        return redirect()->route('salary.index')->with(['update'=>'Salary is successfully updated.']);
    }


    public function destroy(Salary $salary)
    {
        $salary->delete();
        return 'success';
    }
}
