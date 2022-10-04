<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartment;
use App\Http\Requests\UpdateDepartment;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{
    public function index()
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('view_department')) {
            abort('403', 'This action is unauthorized');
        }
        return view('department.index');
    }

    public function datatable()
    {
        $data = Department::query();
        return DataTables::of($data)
        ->addColumn('plus-icon', function ($each) {
            return null;
        })
        ->addColumn('action', function ($each) {
            $edit_icon = '';
            $delete_icon = '';
            $user = User::firstWhere('id', auth()->id());
            if ($user->can('edit_department')) {
                $edit_icon = '<a href="'.route('department.edit', $each->id).'" class="edit-icon text-warning"><i class="fa-solid fa-pen-to-square"></i></a>';
            }
            if ($user->can('delete_department')) {
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
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('create_department')) {
            abort('403', 'This action is unauthorized');
        }
        return view('department.create');
    }

    public function store(StoreDepartment $request)
    {
        $validated = $request->validated();
        Department::create($validated);
        return redirect()->route('department.index')->with(['create'=>'Successfully created']);
    }

    public function edit(Department $department)
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('edit_department')) {
            abort('403', 'This action is unauthorized');
        }
        return view('department.edit', compact('department'));
    }


    public function update(UpdateDepartment $request, Department $department)
    {
        $validated = $request->validated();
        $department->update($validated);
        return redirect()->route('department.index')->with(['update'=>'Successfully created']);
    }

    public function destroy(Department $department)
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('delete_department')) {
            abort('403', 'This action is unauthorized');
        }
        $department->delete();
        return 'success';
    }
}
