<!-- Pending task form -->
<div class="col-lg-4 col-12">
    <div class="card mb-3">
        <div class="card-header bg-warning">
            <h6 class="text-white" style="font-size: 19px;"><i class="fa-solid fa-list mr-2"></i>Pending</h6>
        </div>
        <div class="card-body alert-warning">
            <div id="pending-task">
                @foreach (collect($project->tasks)->sortBy('serial_number')->where('status_id',1) as $task)
                <div class="task-item mb-2" data-id="{{$task->id}}">
                    <div class="d-flex justify-content-between mb-0">
                        <h6>{{$task->title}}</h6>
                        <!-- Example split danger button -->
                        <i class="fa-solid fa-ellipsis-vertical text-dark dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown"></i>
                        <div class="dropdown-menu ">
                            <a href="" class="edit_pending_task" data-task="{{base64_encode(json_encode($task))}}"
                                data-task-members="{{base64_encode(json_encode(collect($task->members)->pluck('id')->toArray()))}}"><i
                                    class="fa-solid fa-pen-to-square text-warning"></i>
                                Edit</a>
                            <div class="dropdown-divider"></div>
                            <a href="" data-id="{{$task->id}}" class="delete_pending_task"><i
                                    class="fa-solid fa-trash text-danger"></i> Delete</a>
                        </div>
                    </div>
                    <p class="mb-0"><i
                            class="fa-solid fa-clock mr-2"></i><span>{{Carbon\Carbon::parse($task->start_date)->format('M
                            d')}}</span>
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        @if ($task->priority_id == 1)
                        <p class="badge badge-pill badge-danger mb-0">high</p>
                        @elseif($task->priority_id == 2)
                        <p class="badge badge-pill badge-primary mb-0">middle</p>
                        @elseif($task->priority_id == 3)
                        <p class="badge badge-pill badge-dark mb-0">low</p>
                        @endif
                        <div class="member-profile">
                            @foreach ($task->members as $member)
                            <img src="{{$member->profile_image_path()}}" alt="">
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="" class="btn btn-block bg-white text-centre add_pending_task">
                <p style="font-size: 18px;" class="mb-2 mt-1">
                    <i class="fa-solid fa-circle-plus mr-1"></i>Add Task
                </p>
            </a>
        </div>
    </div>
</div>
<!-- Inprogress task form -->
<div class="col-lg-4 col-12">
    <div class="card mb-3">
        <div class="card-header bg-info">
            <h6 class="text-white" style="font-size: 19px;"><i class="fa-solid fa-list mr-2"></i>In Progress</h6>
        </div>
        <div class="card-body alert-info">
            <div id="inprogress-task">
                @foreach (collect($project->tasks)->sortBy('serial_number')->where('status_id',2) as $task)
                <div class="task-item mb-2" data-id="{{$task->id}}">
                    <div class="d-flex justify-content-between mb-0">
                        <h6>{{$task->title}}</h6>
                        <i class="fa-solid fa-ellipsis-vertical text-dark dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown"></i>
                        <div class="dropdown-menu ">
                            <a href="" class="edit_inprogress_task" data-task="{{base64_encode(json_encode($task))}}"
                                data-task-members="{{base64_encode(json_encode(collect($task->members)->pluck('id')->toArray()))}}"><i
                                    class="fa-solid fa-pen-to-square text-warning"></i>
                                Edit</a>
                            <div class="dropdown-divider"></div>
                            <a href="" data-id="{{$task->id}}" class="delete_inprogress_task"><i
                                    class="fa-solid fa-trash text-danger"></i> Delete</a>
                        </div>
                    </div>
                    <p class="mb-0"><i
                            class="fa-solid fa-clock mr-2"></i><span>{{Carbon\Carbon::parse($task->start_date)->format('M
                            d')}}</span>
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        @if ($task->priority_id == 1)
                        <p class="badge badge-pill badge-danger mb-0">high</p>
                        @elseif($task->priority_id == 2)
                        <p class="badge badge-pill badge-primary mb-0">middle</p>
                        @elseif($task->priority_id == 3)
                        <p class="badge badge-pill badge-dark mb-0">low</p>
                        @endif
                        <div class="member-profile">
                            @foreach ($task->members as $member)
                            <img src="{{$member->profile_image_path()}}" alt="">
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="" class="btn btn-block bg-white text-center add_inprogress_task">
                <p style="font-size: 18px;" class="mb-2 mt-1">
                    <i class="fa-solid fa-circle-plus mr-1"></i>Add Task
                </p>
            </a>
        </div>
    </div>
</div>
<!-- Complete task form -->
<div class="col-lg-4 col-12">
    <div class="card mb-3">
        <div class="card-header bg-success">
            <h6 class="text-white" style="font-size: 19px;"><i class="fa-solid fa-list mr-2"></i>Complete</h6>
        </div>
        <div class="card-body alert-success">
            <div id="complete-task">
                @foreach (collect($project->tasks)->sortBy('serial_number')->where('status_id',3) as $task)
                <div class="task-item mb-2" data-id="{{$task->id}}">
                    <div class="d-flex justify-content-between mb-0">
                        <h6>{{$task->title}}</h6>
                        <i class="fa-solid fa-ellipsis-vertical text-dark dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown"></i>
                        <div class="dropdown-menu ">
                            <a href="" class="edit_complete_task" data-task="{{base64_encode(json_encode($task))}}"
                                data-task-members="{{base64_encode(json_encode(collect($task->members)->pluck('id')->toArray()))}}"><i
                                    class="fa-solid fa-pen-to-square text-warning"></i>
                                Edit</a>
                            <div class="dropdown-divider"></div>
                            <a href="" data-id="{{$task->id}}" class="delete_complete_task"><i
                                    class="fa-solid fa-trash text-danger"></i> Delete</a>
                        </div>
                    </div>
                    <p class="mb-0"><i
                            class="fa-solid fa-clock mr-2"></i><span>{{Carbon\Carbon::parse($task->start_date)->format('M
                            d')}}</span>
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        @if ($task->priority_id == 1)
                        <p class="badge badge-pill badge-danger mb-0">high</p>
                        @elseif($task->priority_id == 2)
                        <p class="badge badge-pill badge-primary mb-0">middle</p>
                        @elseif($task->priority_id == 3)
                        <p class="badge badge-pill badge-dark mb-0">low</p>
                        @endif

                        <div class="member-profile">
                            @foreach ($task->members as $member)
                            <img src="{{$member->profile_image_path()}}" alt="">
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="" class="btn btn-block bg-white text-center add_complete_task">
                <p style="font-size: 18px;" class="mb-2 mt-1">
                    <i class="fa-solid fa-circle-plus mr-1"></i>Add Task
                </p>
            </a>
        </div>
    </div>
</div>