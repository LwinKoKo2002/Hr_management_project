<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('view_role')) {
            abort('403', 'This action is unauthorized');
        }
        return view('role.index');
    }

    public function datatable()
    {
        $data = Role::query();
        return DataTables::of($data)
        ->addColumn('plus-icon', function ($each) {
            return null;
        })
        ->addColumn('permission', function ($each) {
            $output = '';
            foreach ($each->permissions as $permission) {
                $output .= '<span class="badge badge-pill badge-primary mr-2 mb-2">'.$permission->name.'</span>';
            }
            return $output;
        })
        ->addColumn('action', function ($each) {
            $edit_icon = '';
            $delete_icon = '';
            $user = User::firstWhere('id', auth()->id());
            if ($user->can('edit_role')) {
                $edit_icon = '<a href="'.route('roles.edit', $each->id).'" class="edit-icon text-warning"><i class="fa-solid fa-pen-to-square"></i></a>';
            }

            if ($user->can('delete_role')) {
                $delete_icon = '<a href="" class="info-icon text-danger delete" data-id="'.$each->id.'"><i class="fa-solid fa-trash-can"></i></a>';
            }

            return "<div class='action-icon'>".$edit_icon . $delete_icon ."</div>";
        })
        ->editColumn('updated_at', function ($each) {
            return $each->updated_at->format("d-m-Y H:i:s");
        })
        ->rawColumns(['permission','action'])
        ->make(true);
    }

    public function create()
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('create_role')) {
            abort('403', 'This action is unauthorized');
        }
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $validated = $request->validated();
        $role = Role::create($validated);
        $role->givePermissionTo($request->permissions);
        return redirect()->route('roles.index')->with(['create'=>'One role is successfully created.']);
    }

    public function edit(Role $role)
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('edit_role')) {
            abort('403', 'This action is unauthorized');
        }
        $permissions = Permission::all();
        $old_permissions = $role->permissions->pluck('id')->toArray();
        return view('role.edit', compact('role', 'permissions', 'old_permissions'));
    }

    public function update(RoleUpdateRequest $request, Role $role)
    {
        $validated = $request->validated();
        $role->update($validated);
        $role->revokePermissionTo($role->permissions);
        $role->givePermissionTo($request->permissions);
        return redirect()->route('roles.index')->with(['update'=>'One role is successfully updated.']);
    }

    public function destroy(Role $role)
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('delete_role')) {
            abort('403', 'This action is unauthorized');
        }
        $role->delete();
        return 'success';
    }
}
