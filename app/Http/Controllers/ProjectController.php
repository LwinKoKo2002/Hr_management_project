<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Status;
use App\Models\Project;
use App\Models\Priority;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('view_project')) {
            abort('403', 'This action is unauthorized');
        }
        return view('project.index');
    }

    public function datatable()
    {
        $data = Project::with('leaders', 'members');
        return DataTables::of($data)

        ->addColumn('plus-icon', function ($each) {
            return null;
        })
        ->addColumn('action', function ($each) {
            $edit_icon = '';
            $delete_icon = '';
            $user = User::firstWhere('id', auth()->id());
            if ($user->can('edit_project')) {
                $edit_icon = '<a href="'.route('project.edit', $each->id).'" class="edit-icon text-warning"><i class="fa-solid fa-pen-to-square"></i></a>';
            }
            if ($user->can('view_employee')) {
                $info_icon = '<a href="'.route('project.show', $each->id).'" class="info-icon text-primary"><i class="fa-solid fa-circle-info"></i></a>';
            }

            if ($user->can('delete_project')) {
                $delete_icon = '<a href="" class="info-icon text-danger delete" data-id="'.$each->id.'"><i class="fa-solid fa-trash-can"></i></a>';
            }
            return "<div class='action-icon'>".$edit_icon. $info_icon . $delete_icon ."</div>";
        })
        ->editColumn('description', function ($each) {
            return Str::limit($each->description, '100');
        })
        ->editColumn('priority', function ($each) {
            $priority = $each->priority??'-';
            $output = '';
            if ($priority->name == 'high') {
                $output = '<span class="badge badge-pill badge-danger">high</spam>';
            } elseif ($priority->name = 'middle') {
                $output ='<span class="badge badge-pill badge-warning">high</spam>';
            } elseif ($priority->name == 'low') {
                $output = '<span class="badge badge-pill badge-dark text-white">high</spam>';
            }
            return $output;
        })
        ->editColumn('status', function ($each) {
            $status = $each->status??'-';
            $output = '';
            if ($status->name === 'pending') {
                $output = '<span class="badge badge-pill badge-danger">pending</spam>';
            } elseif ($status->name === 'inprogress') {
                $output = '<span class="badge badge-pill badge-primary">inprogress</spam>';
            } elseif ($status->name === 'complete') {
                $output = '<span class="badge badge-pill badge-success">complete</spam>';
            }
            return $output;
        })
        ->addColumn('leaders', function ($each) {
            $output = '';
            foreach ($each->leaders as $leader) {
                $output .= '<img src="'.$leader->profile_image_path().'" alt="profile-img" class="img-thumbnail"/>';
            }
            return "<div class='project'>" . $output . "</div>";
        })
        ->addColumn('members', function ($each) {
            $output = '';
            foreach ($each->members as $member) {
                $output .= '<img src="'.$member->profile_image_path().'" alt="profile-img" class="img-thumbnail"/>';
            }
            return "<div class='project'>" . $output . "</div>";
        })
        ->editColumn('created_at', function ($each) {
            return $each->created_at->format("d-m-Y H:i:s");
        })
        ->editColumn('updated_at', function ($each) {
            return $each->updated_at->format("d-m-Y H:i:s");
        })
        ->rawColumns(['priority','status','action','leaders','members'])
        ->make(true);
    }

    public function create()
    {
        $employees = User::all();
        $priorities = Priority::all();
        $statuses = Status::all();
        return view('project.create', compact('employees', 'priorities', 'statuses'));
    }

 
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();
        $imageArr = null;
        if ($request->hasFile('images')) {
            $imageArr = [];
            $project_image_files = $request->file('images');
            foreach ($project_image_files as $project_image_file) {
                $image_name = uniqid() . '_' . time() . '.'. $project_image_file->getClientOriginalExtension();
                Storage::disk('public')->put('project/'. $image_name, file_get_contents($project_image_file));
                $imageArr[] = $image_name;
            }
        }

        $fileArr = null;
        if ($request->hasFile('files')) {
            $fileArr = [];
            $project_files = $request->file('files');
            foreach ($project_files as $project_file) {
                $file_name = uniqid() . '_' . time() . '.'. $project_file->getClientOriginalExtension();
                Storage::disk('public')->put('project/'. $file_name, file_get_contents($project_file));
                $fileArr[] = $file_name;
            }
        }
        $validated['images'] = $imageArr;
        $validated['files'] = $fileArr;
        $project = Project::create($validated);

        $project->leaders()->sync($request->leaders);
        $project->members()->sync($request->members);
        
        return redirect()->route('project.index')->with(['create'=>'Project is successfully created.']);
    }


    public function show(Project $project)
    {
        $priority = Priority::all();
        return view('project.show', compact('project', 'priority'));
    }


    public function edit(Project $project)
    {
        $employees = User::all();
        $priorities = Priority::all();
        $statuses = Status::all();
        return view('project.edit', compact('project', 'employees', 'priorities', 'statuses'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();
        $imageArr = null;
        if ($request->hasFile('images')) {
            foreach ($project->images as $image) {
                Storage::disk('public')->delete('project/' . $image);
            }
            $imageArr = [];
            $project_image_files = $request->file('images');
            foreach ($project_image_files as $project_image_file) {
                $image_name = uniqid() . '_' . time() . '.'. $project_image_file->getClientOriginalExtension();
                Storage::disk('public')->put('project/'. $image_name, file_get_contents($project_image_file));
                $imageArr[] = $image_name;
            }
        } else {
            $imageArr = $project->images;
        }

        $fileArr = null;
        if ($request->hasFile('files')) {
            foreach ($project->files as $file) {
                Storage::disk('public')->delete('project/' . $file);
            }
            $fileArr = [];
            $project_files = $request->file('files');
            foreach ($project_files as $project_file) {
                $file_name = uniqid() . '_' . time() . '.'. $project_file->getClientOriginalExtension();
                Storage::disk('public')->put('project/'. $file_name, file_get_contents($project_file));
                $fileArr[] = $file_name;
            }
        } else {
            $fileArr = $project->files;
        }

        $validated['images'] = $imageArr;
        $validated['files'] = $fileArr;
        $project->update($validated);

        $project->leaders()->sync($request->leaders);
        $project->members()->sync($request->members);
        
        return redirect()->route('project.index')->with(['update'=>'Project is successfully updated.']);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return 'success';
    }
}
