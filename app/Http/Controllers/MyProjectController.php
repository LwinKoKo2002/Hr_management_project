<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Priority;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MyProjectController extends Controller
{
    public function index()
    {
        return view('my_project.index');
    }

    public function datatable()
    {
        $data = Project::with('leaders', 'members')->where(function ($query) {
            $query->whereHas('leaders', function ($query) {
                $query->where('user_id', auth()->id());
            })->orWhereHas('members', function ($query) {
                $query->where('user_id', auth()->id());
            });
        });
        return DataTables::of($data)

        ->addColumn('plus-icon', function ($each) {
            return null;
        })
        ->addColumn('action', function ($each) {
            $edit_icon = '';
            $delete_icon = '';
            $user = User::firstWhere('id', auth()->id());

            if ($user->can('view_employee')) {
                $info_icon = '<a href="'.route('my-project.show', $each->id).'" class="info-icon text-primary"><i class="fa-solid fa-circle-info"></i></a>';
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


    public function show($id)
    {
        $project =  Project::where('id', $id)->with('leaders', 'members')->where(function ($query) {
            $query->whereHas('leaders', function ($query) {
                $query->where('user_id', auth()->id());
            })->orWhereHas('members', function ($query) {
                $query->where('user_id', auth()->id());
            });
        })->firstOrFail();
        $priority = Priority::all();
        return view('project.show', compact('project', 'priority'));
    }
}
