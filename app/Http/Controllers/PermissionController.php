<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    public function index()
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('view_permission')) {
            abort('403', 'This action is unauthorized');
        }
        return view('permission.index');
    }

    public function datatable()
    {
        $data = Permission::query();
        return DataTables::of($data)
        ->addColumn('plus-icon', function ($each) {
            return null;
        })
        ->addColumn('action', function ($each) {
            $edit_icon = '';
            $delete_icon = '';
            $user = User::firstWhere('id', auth()->id());
            if ($user->can('edit_permission')) {
                $edit_icon = '<a href="'.route('permission.edit', $each->id).'" class="edit-icon text-warning"><i class="fa-solid fa-pen-to-square"></i></a>';
            }

            if ($user->can('delete_permission')) {
                $delete_icon = '<a href="" class="info-icon text-danger delete" data-id="'.$each->id.'"><i class="fa-solid fa-trash-can"></i></a>';
            }

            return "<div class='action-icon'>".$edit_icon . $delete_icon ."</div>";
        })
        ->editColumn('created_at', function ($each) {
            return $each->created_at->format("d-m-Y H:i:s");
        })
        ->editColumn('updated_at', function ($each) {
            return $each->updated_at->format("d-m-Y H:i:s");
        })
        ->make(true);
    }

    public function create()
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('create_permission')) {
            abort('403', 'This action is unauthorized');
        }
        return view('permission.create');
    }

    public function store(PermissionRequest $request)
    {
        $validated = $request->validated();
        Permission::create($validated);
        return redirect()->route('permission.index')->with(['create'=>'Permission is successfully created.']);
    }

    public function edit(Permission $permission)
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('edit_permission')) {
            abort('403', 'This action is unauthorized');
        }
        return view('permission.edit', compact('permission'));
    }

    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        $validated = $request->validated();
        $permission->update($validated);
        return redirect()->route('permission.index')->with(['update'=>'Permission is successfully updated.']);
    }

    public function destroy(Permission $permission)
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('delete_permission')) {
            abort('403', 'This action is unauthorized');
        }
        $permission->delete();
        return 'success';
    }
}
