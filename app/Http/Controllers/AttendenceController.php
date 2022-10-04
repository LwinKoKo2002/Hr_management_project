<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendence;
use App\Http\Requests\UpdateAttendence;
use App\Models\CheckInCheckOut;
use App\Models\CompanySetting;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AttendenceController extends Controller
{
    public function index()
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('view_attendence')) {
            abort('403', 'This action is unauthorized');
        }
        return view('attendence.index');
    }

    public function datatable()
    {
        $data = CheckInCheckOut::query();
        return DataTables::of($data)
        ->addColumn('plus-icon', function ($each) {
            return null;
        })
        ->editColumn('employee', function ($each) {
            $employee = $each->employee ? $each->employee->name : '-';
            return $employee;
        })
        ->addColumn('action', function ($each) {
            $edit_icon = '';
            $delete_icon = '';
            $user = User::firstWhere('id', auth()->id());
            if ($user->can('edit_attendence')) {
                $edit_icon = '<a href="'.route('attendence.edit', $each->id).'" class="edit-icon text-warning"><i class="fa-solid fa-pen-to-square"></i></a>';
            }
            if ($user->can('delete_attendence')) {
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
        return view('attendence.create', compact('employees'));
    }

    public function store(StoreAttendence $request)
    {
        $validated = $request->validated();
        if (CheckInCheckOut::where('user_id', $validated['user_id'])->where('date', $validated['date'])->exists()) {
            return back()->withErrors(['fail'=>'Already checkin and chekout'])->withInput();
        }
        $validated['checkin_time'] = $validated['date']." " . $validated['checkin_time'];
        $validated['checkout_time'] = $validated['date']." " . $validated['checkout_time'];
        CheckInCheckOut::create($validated);
        return redirect()->route('attendence.index')->with(['create'=>'Successfully created']);
    }

    public function edit(CheckInCheckOut $attendence)
    {
        $employees = User::all();
        return view('attendence.edit', compact('attendence', 'employees'));
    }


    public function update(UpdateAttendence $request, CheckInCheckOut $attendence)
    {
        $validated = $request->validated();
        if (CheckInCheckOut::where('user_id', $validated['user_id'])->where('date', $validated['date'])->where('id', '!=', $attendence->id)->exists()) {
            return back()->withErrors(['fail'=>'Invalid data entry'])->withInput();
        }
        $validated['checkin_time'] = $validated['date']." " . $validated['checkin_time'];
        $validated['checkout_time'] = $validated['date']." " . $validated['checkout_time'];
        $attendence->update($validated);
        return redirect()->route('attendence.index')->with(['update'=>'Successfully updated']);
    }

 
    public function destroy(CheckInCheckOut $attendence)
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('delete_department')) {
            abort('403', 'This action is unauthorized');
        }
        $attendence->delete();
        return 'success';
    }

    public function overview()
    {
        return view('attendence.overview');
    }

    public function overviewTable(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $employees = User::where('name', 'LIKE', '%'.$request->employee.'%')->get();
        $startMonth = $year.'-'.$month.'-'.'01';
        $endMonth = Carbon::parse($startMonth)->endOfMonth();
        $periods = new CarbonPeriod($startMonth, $endMonth);
        $setting = CompanySetting::findOrFail(1);
        $attendances = CheckInCheckOut::whereMonth('date', $month)->whereYear('date', $year)->get();
        return view('components.attendance_overview_table', compact('employees', 'periods', 'setting', 'attendances'))->render();
    }

    public function myDatatable(Request $request)
    {
        $attendances = CheckInCheckOut::where('user_id', auth()->id());
        if ($request->month) {
            $attendances = $attendances->whereMonth('date', $request->month);
        }

        if ($request->year) {
            $attendances = $attendances->whereYear('date', $request->year);
        }

        return DataTables::of($attendances)
        ->addColumn('plus-icon', function ($each) {
            return null;
        })
        ->filterColumn('employee', function ($query, $keyword) {
            $query->whereHas('employee', function ($query) use ($keyword) {
                $query->where('name', 'like', '%'.$keyword.'%');
            });
        })
        ->editColumn('employee', function ($each) {
            $employee = $each->employee ? $each->employee->name : '-';
            return $employee;
        })
        ->editColumn('updated_at', function ($each) {
            return $each->updated_at->format("d-m-Y H:i:s");
        })
        ->make(true);
    }

    public function myOverviewTable(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $employees = User::where('id', auth()->id())->get();
        $startMonth = $year.'-'.$month.'-'.'01';
        $endMonth = Carbon::parse($startMonth)->endOfMonth();
        $periods = new CarbonPeriod($startMonth, $endMonth);
        $setting = CompanySetting::findOrFail(1);
        $attendances = CheckInCheckOut::whereMonth('date', $month)->whereYear('date', $year)->get();
        return view('components.attendance_overview_table', compact('employees', 'periods', 'setting', 'attendances'))->render();
    }
}
