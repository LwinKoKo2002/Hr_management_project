<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployee;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('view_employee')) {
            abort('403', 'This action is unauthorized');
        }
        return view('employee.index');
    }

    public function datatable()
    {
        $data = User::with('department');
        return DataTables::of($data)
        ->addColumn('plus-icon', function ($each) {
            return null;
        })
        ->filterColumn('department', function ($query, $keyword) {
            $query->whereHas('department', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%'.$keyword.'%');
            });
        })
        ->addColumn('role', function ($each) {
            $output = '';
            foreach ($each->roles as $role) {
                $output.='<span class="badge badge-pill badge-primary">'.$role->name.'</span>';
            }
            return $output;
        })
        ->editColumn('profile_image', function ($each) {
            return '<img src="'. $each->profile_image_path() .'" class="profile-image"/>';
        })
        ->addColumn('department', function ($each) {
            $department_name = $each->department ? $each->department->name : '-';
            return "<span>$department_name</span>";
        })
        ->editColumn('is_present', function ($each) {
            if ($each->is_present == 1) {
                return  '<span class="badge badge-pill badge-success">Present</span>';
            } else {
                return  '<span class="badge badge-pill badge-danger">Leave</span>';
            }
        })
        ->addColumn('action', function ($each) {
            $edit_icon = '';
            $info_icon = '';
            $delete_icon = '';
            $user = User::firstWhere('id', auth()->id());
            if ($user->can('edit_employee')) {
                $edit_icon = '<a href="'.route('employee.edit', $each->id).'" class="edit-icon text-warning"><i class="fa-solid fa-pen-to-square"></i></a>';
            }
            if ($user->can('view_employee')) {
                $info_icon = '<a href="'.route('employee.show', $each->id).'" class="info-icon text-primary"><i class="fa-solid fa-circle-info"></i></a>';
            }
            if ($user->can('delete_employee')) {
                $delete_icon = '<a href="" class="info-icon text-danger delete" data-id="'.$each->id.'"><i class="fa-solid fa-trash-can"></i></a>';
            }
            return "<div class='action-icon'>".$edit_icon . $info_icon . $delete_icon ."</div>";
        })
        ->rawColumns(['is_present','action','department','profile_image','role'])
        ->editColumn('updated_at', function ($each) {
            return $each->updated_at->format("d-m-Y H:i:s");
        })
        ->make(true);
    }
    
    public function create()
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('create_employee')) {
            abort('403', 'This action is unauthorized');
        }
        $departments = Department::latest()->get();
        $roles = Role::all();
        return view('employee.create', [
            'departments'=>$departments,
            'roles'=>$roles
        ]);
    }

 
    public function store(StoreEmployee $request)
    {
        $validated = $request->validated();
        $profie_image_name = '';
        if ($request->hasFile('profile_img')) {
            $profile_image_file = $request->file('profile_img');
            $profie_image_name = uniqid() . '_' . time() . '.'. $profile_image_file->getClientOriginalExtension();
            Storage::disk('public')->put('employee/'. $profie_image_name, file_get_contents($profile_image_file));
        }
        $validated['profile_img'] = $profie_image_name;
        $employee = User::create($validated);
        $employee->syncRoles($request->roles);
        return redirect()->route('employee.index')->with(['create'=>'Successfully created']);
    }


    public function show(User $employee)
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('view_employee')) {
            abort('404', 'This action is unauthorized');
        }
        $roles = $employee->roles;
        return view('employee.show', compact('employee', 'roles'));
    }


    public function edit(User $employee)
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('edit_employee')) {
            abort('404', 'This action is unauthorized');
        }
        $roles = Role::all();
        $old_roles = $employee->roles->pluck('name')->toArray();
        $departments = Department::latest()->get();
        return view('employee.edit', compact(['employee','departments','roles','old_roles']));
    }

 
    public function update(UpdateEmployeeRequest $request, User $employee)
    {
        $validated = $request->validated();
        if ($request->hasFile('profile_img')) {
            Storage::disk('public')->delete('employee/'.$employee->profile_img);
            $profile_image_file = $request->file('profile_img');
            $profie_image_name = uniqid() . '_' . time() . '.'. $profile_image_file->getClientOriginalExtension();
            Storage::disk('public')->put('employee/'. $profie_image_name, file_get_contents($profile_image_file));
            $validated['profile_img'] = $profie_image_name;
        } else {
            $validated['profile_img'] = $employee->profile_img;
        }
        $validated['pin_code'] = $validated['pin_code']??$employee->pin_code;
        $employee->update($validated);
        $employee->syncRoles($request->roles);
        return redirect()->route('employee.index')->with(['update'=>'Successfully updated']);
    }


    public function destroy(User $employee)
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('delete_employee')) {
            abort('404', 'This action is unauthorized');
        }
        $employee->delete();
        return 'success';
    }
}
