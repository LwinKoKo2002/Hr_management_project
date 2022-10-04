<x-layout>
    <x-slot name="title">
        Project Detail
    </x-slot>
    <div class="project-detail">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5>{{ucwords($project->title)}}</h5>
                                <p>Start Date : <span class="text-muted">{{$project->start_date}}</span> ,
                                    Deadline : <span class="text-muted">{{$project->dead_line}}</span> </p>

                                <p>
                                    Priority :
                                    @if ($project->priority_id === 1)
                                    <span class="badge badge-pill badge-danger">high</span>
                                    @elseif ($project->priority_id === 2)
                                    <span class="badge badge-pill badge-warning">middle</span>
                                    @elseif ($project->priority_id === 3)
                                    <span class="badge badge-pill badge-dark text-white">low</span>
                                    @endif
                                    ,
                                    Status :
                                    @if ($project->status_id === 1)
                                    <span class="badge badge-pill badge-warning">pending</span>
                                    @elseif ($project->status_id === 2)
                                    <span class="badge badge-pill badge-primary">inprogress</span>
                                    @elseif ($project->status_id === 3)
                                    <span class="badge badge-pill badge-danger">complete</span>
                                    @endif
                                </p>
                                <h5>Description</h5>
                                <p>{{$project->description}}</p>

                                <div class="project-image">
                                    <h5>Leaders</h5>
                                    @foreach ($project->leaders as $leader)
                                    <img src="{{$leader->profile_image_path()}}" alt="profile-img"
                                        class="img-thumbnail">
                                    @endforeach
                                    <h5 class="mt-4">Members</h5>
                                    @foreach ($project->members as $member)
                                    <img src="{{$member->profile_image_path()}}" alt="profile-img"
                                        class="img-thumbnail">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" col-lg-3 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5>Images</h5>
                                @if ($project->images)
                                <div id="images">
                                    @foreach ($project->images as $image)
                                    <img src="{{asset('/storage/project/'.$image)}}" alt="profie image"
                                        class="thumbnail" id="profile">
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5>Files</h5>
                                @if ($project->files)
                                @foreach ($project->files as $file)
                                <div class="file">
                                    <a href="{{asset('/storage/project/'.$file)}}" target="_blank">
                                        <i class="fa-solid fa-file-pdf"></i>
                                        <p>File {{$loop->iteration}}</p>
                                    </a>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card task-detail">
                    <div class="card-body">
                        <h5 style="font-size: 23px;" class="mb-3">Tasks</h5>
                        <div class="row show-task-data">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            $(document).ready(function(){
                //Image Viewer
                const gallery = new Viewer(document.getElementById('images'));
                
                var project_id = "{{$project->id}}";
                var priority = @json($priority);
                var members = @json($project->members);
                var leaders = @json($project->leaders);

                function initDrag(){
                    var pendingTask = document.getElementById('pending-task');
                    var inprogressTask = document.getElementById('inprogress-task');
                    var completeTask = document.getElementById('complete-task');

                     Sortable.create(pendingTask,{
                        group: "taskBoard", 
                        animation: 200,
                        ghostClass: "ghost",
                        store: {
                            set: function(sortable){
                                var order = sortable.toArray();
                                localStorage.setItem('pendingTaskBoard',order.join(','));
                            }
                        },
                        onSort: function (evt) {
                            setTimeout(() => {
                                var pendingTaskItem = localStorage.getItem('pendingTaskBoard');
                                $.ajax({
                                    url:`/taskDraggable?project_id=${project_id}&pendingTaskItem=${pendingTaskItem}`,
                                    type: 'POST',
                                    success : function(res){
                                        console.log('res');
                                    }
                                })
                            }, 2000);
	                    },
                     });     

                     Sortable.create(inprogressTask,{
                        group: "taskBoard", 
                        animation: 200,
                        ghostClass: "ghost",
                        store: {
                            set: function(sortable){
                                var order = sortable.toArray();
                                localStorage.setItem('inprogressTaskBoard',order.join(','));
                            }
                        },
                        onSort: function (evt) {
                            setTimeout(() => {
                                var inprogressTaskItem = localStorage.getItem('inprogressTaskBoard');
                                $.ajax({
                                    url:`/taskDraggable?project_id=${project_id}&inprogressTaskItem=${inprogressTaskItem}`,
                                    type: 'POST',
                                    success : function(res){
                                        console.log('res');
                                    }
                                })
                            }, 2000);
	                    },
                     });     

                     Sortable.create(completeTask,{
                        group: "taskBoard", 
                        animation: 200,
                        ghostClass: "ghost",
                        store: {
                            set: function(sortable){
                                var order = sortable.toArray();
                                localStorage.setItem('completeTaskBoard',order.join(','));
                            }
                        },
                        onSort: function (evt) {
                            setTimeout(() => {
                                var completeTaskItem = localStorage.getItem('completeTaskBoard');
                                $.ajax({
                                    url:`/taskDraggable?project_id=${project_id}&completeTaskItem=${completeTaskItem}`,
                                    type: 'POST',
                                    success : function(res){
                                        console.log('res');
                                    }
                                })
                            }, 2000);
	                    },
                     });     
                }

                taskData();
                function taskData(){
                    $.ajax({
                        url : '/task-data?project_id='+project_id,
                        type : 'GET',
                        success : function(res){
                            $('.show-task-data').html(res);
                            initDrag();
                        }
                    })
                }

                //Store Task
                $(document).on('click','.add_pending_task',function(e){
                    e.preventDefault();

                    var priority_options = '';
                    var member_options = '';
                    
                    members.forEach(function(member){
                        member_options += `<option value=${member.id}>${member.name}</option>`;
                    })

                    leaders.forEach(function(leader){
                        member_options += `<option value=${leader.id}>${leader.name}</option>`;
                    })

                    priority.forEach(function(priority){
                        priority_options +=`<option value=${priority.id}>${priority.name}</option>`;
                    });

                    Swal.fire({
                    title: 'Add Pendign Task',
                    confirmButtonText: 'Submit',
                    focusConfirm: false,
                    html:`
                        <form id="add_pending_task">
                            <input type="hidden" name="project_id" value="${project_id}">
                            <input type="hidden" name="status_id" value="1">
                            <div class="form-group">
                            <label style="float:left;">Title</label>
                            <input type="text" name="title" class="form-control mb-3" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Description</label>
                            <textarea name="description" col="10" row="1" class="form-control" style="border:1px solid #ddd"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="d-flex">Members</label>
                                <select name="members[]" class="form-control select-member" style="border:1px solid #ddd" multiple>
                                    <option value=""></option>
                                    ${member_options}
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Start Date</label>
                                <input type="text" name="start_date" id="start_date" class="form-control" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Dead Line</label>
                                <input type="text" name="dead_line" id="dead_line" class="form-control" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label class="d-flex">Description</label>
                                <select name="priority_id" class="form-control select-priority" style="border:1px solid #ddd">
                                    <option value=""></option>
                                    ${priority_options}
                                </select>
                            </div>
                        </form>
                        `,
                    }).then((result) => {
                        if (result.isConfirmed) {
                               var pending_task_form = $('#add_pending_task').serialize();
                               $.ajax({
                                    url : '{{route("task.store")}}',
                                    type : 'POST',
                                    data : pending_task_form,
                                    success : function(res){
                                       taskData();
                                    },
                               })
                            }   
                        })

                    $('.select-priority').select2({
                        placeholder : '-- Please Choose (Priority) --',
                        allowClear : true,
                        theme : 'bootstrap4',
                    });

                    $('.select-member').select2({
                        placeholder : '-- Please Choose (Members) --',
                        allowClear : true,
                        theme : 'bootstrap4',
                    });

                    $('#start_date').daterangepicker({
                        "singleDatePicker": true,
                        "showDropdowns": true,
                        "autoApply": true,
                        "maxdate" : moment(),
                        "locale": {
                            "format": "YYYY-MM-DD",
                            }
                    });

                    $('#dead_line').daterangepicker({
                        "singleDatePicker": true,
                        "showDropdowns": true,
                        "autoApply": true,
                        "maxdate" : moment(),
                        "locale": {
                            "format": "YYYY-MM-DD",
                            }
                    });
                })

                $(document).on('click','.add_inprogress_task',function(e){
                    e.preventDefault();

                    var priority_options = '';
                    var member_options = '';
                    
                    members.forEach(function(member){
                        member_options += `<option value=${member.id}>${member.name}</option>`;
                    })

                    leaders.forEach(function(leader){
                        member_options += `<option value=${leader.id}>${leader.name}</option>`;
                    })

                    priority.forEach(function(priority){
                        priority_options +=`<option value=${priority.id}>${priority.name}</option>`;
                    });

                    Swal.fire({
                    title: 'Add Inprogress Task',
                    confirmButtonText: 'Submit',
                    focusConfirm: false,
                    html:`
                        <form id="add_inprogress_task">
                            <input type="hidden" name="project_id" value="${project_id}">
                            <input type="hidden" name="status_id" value="2">
                            <div class="form-group">
                            <label style="float:left;">Title</label>
                            <input type="text" name="title" class="form-control mb-3" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Description</label>
                            <textarea name="description" col="10" row="1" class="form-control" style="border:1px solid #ddd"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="d-flex">Members</label>
                                <select name="members[]" class="form-control select-member" style="border:1px solid #ddd" multiple>
                                    <option value=""></option>
                                    ${member_options}
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Start Date</label>
                                <input type="text" name="start_date" id="start_date" class="form-control" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Dead Line</label>
                                <input type="text" name="dead_line" id="dead_line" class="form-control" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label class="d-flex">Description</label>
                                <select name="priority_id" class="form-control select-priority" style="border:1px solid #ddd">
                                    <option value=""></option>
                                    ${priority_options}
                                </select>
                            </div>
                        </form>
                        `,
                    }).then((result) => {
                        if (result.isConfirmed) {
                               var inprogress_task_form = $('#add_inprogress_task').serialize();
                               $.ajax({
                                    url : '{{route("task.store")}}',
                                    type : 'POST',
                                    data : inprogress_task_form,
                                    success : function(res){
                                       taskData();
                                    },
                               })
                            }   
                        })

                    $('.select-priority').select2({
                        placeholder : '-- Please Choose (Priority) --',
                        allowClear : true,
                        theme : 'bootstrap4',
                    });

                    $('.select-member').select2({
                        placeholder : '-- Please Choose (Members) --',
                        allowClear : true,
                        theme : 'bootstrap4',
                    });

                    $('#start_date').daterangepicker({
                        "singleDatePicker": true,
                        "showDropdowns": true,
                        "autoApply": true,
                        "maxdate" : moment(),
                        "locale": {
                            "format": "YYYY-MM-DD",
                            }
                    });

                    $('#dead_line').daterangepicker({
                        "singleDatePicker": true,
                        "showDropdowns": true,
                        "autoApply": true,
                        "maxdate" : moment(),
                        "locale": {
                            "format": "YYYY-MM-DD",
                            }
                    });
                })

                $(document).on('click','.add_complete_task',function(e){
                    e.preventDefault();

                    var priority_options = '';
                    var member_options = '';
                    
                    members.forEach(function(member){
                        member_options += `<option value=${member.id}>${member.name}</option>`;
                    })

                    leaders.forEach(function(leader){
                        member_options += `<option value=${leader.id}>${leader.name}</option>`;
                    })

                    priority.forEach(function(priority){
                        priority_options +=`<option value=${priority.id}>${priority.name}</option>`;
                    });

                    Swal.fire({
                    title: 'Add Complete Task',
                    confirmButtonText: 'Submit',
                    focusConfirm: false,
                    html:`
                        <form id="add_complete_task">
                            <input type="hidden" name="project_id" value="${project_id}">
                            <input type="hidden" name="status_id" value="3">
                            <div class="form-group">
                            <label style="float:left;">Title</label>
                            <input type="text" name="title" class="form-control mb-3" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Description</label>
                            <textarea name="description" col="10" row="1" class="form-control" style="border:1px solid #ddd"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="d-flex">Members</label>
                                <select name="members[]" class="form-control select-member" style="border:1px solid #ddd" multiple>
                                    <option value=""></option>
                                    ${member_options}
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Start Date</label>
                                <input type="text" name="start_date" id="start_date" class="form-control" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Dead Line</label>
                                <input type="text" name="dead_line" id="dead_line" class="form-control" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label class="d-flex">Description</label>
                                <select name="priority_id" class="form-control select-priority" style="border:1px solid #ddd">
                                    <option value=""></option>
                                    ${priority_options}
                                </select>
                            </div>
                        </form>
                        `,
                    }).then((result) => {
                        if (result.isConfirmed) {
                               var complete_task_form = $('#add_complete_task').serialize();
                               $.ajax({
                                    url : '{{route("task.store")}}',
                                    type : 'POST',
                                    data : complete_task_form,
                                    success : function(res){
                                       taskData();
                                    },
                               })
                            }   
                        })

                    $('.select-priority').select2({
                        placeholder : '-- Please Choose (Priority) --',
                        allowClear : true,
                        theme : 'bootstrap4',
                    });

                    $('.select-member').select2({
                        placeholder : '-- Please Choose (Members) --',
                        allowClear : true,
                        theme : 'bootstrap4',
                    });

                    $('#start_date').daterangepicker({
                        "singleDatePicker": true,
                        "showDropdowns": true,
                        "autoApply": true,
                        "maxdate" : moment(),
                        "locale": {
                            "format": "YYYY-MM-DD",
                            }
                    });

                    $('#dead_line').daterangepicker({
                        "singleDatePicker": true,
                        "showDropdowns": true,
                        "autoApply": true,
                        "maxdate" : moment(),
                        "locale": {
                            "format": "YYYY-MM-DD",
                            }
                    });
                })

                // Edit Task
                $(document).on('click','.edit_pending_task',function(e){
                    e.preventDefault();

                    var task = JSON.parse(atob($(this).data('task')));
                    var task_members = JSON.parse(atob($(this).data('task-members')));
                    var priority_options = '';
                    var member_options = '';
                    
                    members.forEach(function(member){
                        member_options += `<option value=${member.id} ${task_members.includes(member.id) ? 'selected' : '' }>${member.name}</option>`;
                    })

                    leaders.forEach(function(leader){
                        member_options += `<option value=${leader.id} ${task_members.includes(leader.id) ? 'selected' : '' }>${leader.name}</option>`;
                    })

                    priority.forEach(function(priority){
                        priority_options +=`<option value=${priority.id} ${(task.priority_id == priority.id) ? 'selected' : ''}>${priority.name}</option>`;
                    });

                    Swal.fire({
                    title: 'Add Complete Task',
                    focusConfirm: false,
                    confirmButtonText: 'Update',
                    html:`
                        <form id="update_pending_task">
                            <div class="form-group">
                            <label style="float:left;">Title</label>
                            <input type="text" name="title" class="form-control mb-3" style="border:1px solid #ddd" value=${task.title}>
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Description</label>
                            <textarea name="description" col="10" row="1" class="form-control" style="border:1px solid #ddd">${task.description}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="d-flex">Members</label>
                                <select name="members[]" class="form-control select-member" style="border:1px solid #ddd" multiple>
                                    <option value=""></option>
                                    ${member_options}
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Start Date</label>
                                <input type="text" name="start_date" id="start_date" class="form-control" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Dead Line</label>
                                <input type="text" name="dead_line" id="dead_line" class="form-control" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label class="d-flex">Description</label>
                                <select name="priority_id" class="form-control select-priority" style="border:1px solid #ddd">
                                    <option value=""></option>
                                    ${priority_options}
                                </select>
                            </div>
                        </form>
                        `,
                    }).then((result) => {
                        if (result.isConfirmed) {
                               var update_task_form = $('#update_pending_task').serialize();
                               $.ajax({
                                    url : `/task/${task.id}`,
                                    type : 'PUT',
                                    data : update_task_form,
                                    success : function(res){
                                       taskData();
                                    },
                               })
                           
                            }   
                        })

                    $('.select-priority').select2({
                        placeholder : '-- Please Choose (Priority) --',
                        allowClear : true,
                        theme : 'bootstrap4',
                    });

                    $('.select-member').select2({
                        placeholder : '-- Please Choose (Members) --',
                        allowClear : true,
                        theme : 'bootstrap4',
                    });

                    $('#start_date').daterangepicker({
                        "singleDatePicker": true,
                        "showDropdowns": true,
                        "autoApply": true,
                        "maxdate" : moment(),
                        "locale": {
                            "format": "YYYY-MM-DD",
                            }
                    });

                    $('#dead_line').daterangepicker({
                        "singleDatePicker": true,
                        "showDropdowns": true,
                        "autoApply": true,
                        "maxdate" : moment(),
                        "locale": {
                            "format": "YYYY-MM-DD",
                            }
                    });
                })

                $(document).on('click','.edit_inprogress_task',function(e){
                    e.preventDefault();

                    var task = JSON.parse(atob($(this).data('task')));
                    var task_members = JSON.parse(atob($(this).data('task-members')));
                    var priority_options = '';
                    var member_options = '';
                    
                    members.forEach(function(member){
                        member_options += `<option value=${member.id} ${task_members.includes(member.id) ? 'selected' : '' }>${member.name}</option>`;
                    })

                    leaders.forEach(function(leader){
                        member_options += `<option value=${leader.id} ${task_members.includes(leader.id) ? 'selected' : '' }>${leader.name}</option>`;
                    })

                    priority.forEach(function(priority){
                        priority_options +=`<option value=${priority.id} ${(task.priority_id == priority.id) ? 'selected' : ''}>${priority.name}</option>`;
                    });

                    Swal.fire({
                    title: 'Add Complete Task',
                    focusConfirm: false,
                    confirmButtonText: 'Update',
                    html:`
                        <form id="update_inprogress_task">
                            <div class="form-group">
                            <label style="float:left;">Title</label>
                            <input type="text" name="title" class="form-control mb-3" style="border:1px solid #ddd" value=${task.title}>
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Description</label>
                            <textarea name="description" col="10" row="1" class="form-control" style="border:1px solid #ddd">${task.description}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="d-flex">Members</label>
                                <select name="members[]" class="form-control select-member" style="border:1px solid #ddd" multiple>
                                    <option value=""></option>
                                    ${member_options}
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Start Date</label>
                                <input type="text" name="start_date" id="start_date" class="form-control" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Dead Line</label>
                                <input type="text" name="dead_line" id="dead_line" class="form-control" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label class="d-flex">Description</label>
                                <select name="priority_id" class="form-control select-priority" style="border:1px solid #ddd">
                                    <option value=""></option>
                                    ${priority_options}
                                </select>
                            </div>
                        </form>
                        `,
                    }).then((result) => {
                        if (result.isConfirmed) {
                               var update_task_form = $('#update_inprogress_task').serialize();
                               $.ajax({
                                    url : `/task/${task.id}`,
                                    type : 'PUT',
                                    data : update_task_form,
                                    success : function(res){
                                       taskData();
                                    },
                               })
                           
                            }   
                        })

                    $('.select-priority').select2({
                        placeholder : '-- Please Choose (Priority) --',
                        allowClear : true,
                        theme : 'bootstrap4',
                    });

                    $('.select-member').select2({
                        placeholder : '-- Please Choose (Members) --',
                        allowClear : true,
                        theme : 'bootstrap4',
                    });

                    $('#start_date').daterangepicker({
                        "singleDatePicker": true,
                        "showDropdowns": true,
                        "autoApply": true,
                        "maxdate" : moment(),
                        "locale": {
                            "format": "YYYY-MM-DD",
                            }
                    });

                    $('#dead_line').daterangepicker({
                        "singleDatePicker": true,
                        "showDropdowns": true,
                        "autoApply": true,
                        "maxdate" : moment(),
                        "locale": {
                            "format": "YYYY-MM-DD",
                            }
                    });
                })

                $(document).on('click','.edit_complete_task',function(e){
                    e.preventDefault();

                    var task = JSON.parse(atob($(this).data('task')));
                    var task_members = JSON.parse(atob($(this).data('task-members')));
                    var priority_options = '';
                    var member_options = '';
                    
                    members.forEach(function(member){
                        member_options += `<option value=${member.id} ${task_members.includes(member.id) ? 'selected' : '' }>${member.name}</option>`;
                    })

                    leaders.forEach(function(leader){
                        member_options += `<option value=${leader.id} ${task_members.includes(leader.id) ? 'selected' : '' }>${leader.name}</option>`;
                    })

                    priority.forEach(function(priority){
                        priority_options +=`<option value=${priority.id} ${(task.priority_id == priority.id) ? 'selected' : ''}>${priority.name}</option>`;
                    });

                    Swal.fire({
                    title: 'Add Complete Task',
                    focusConfirm: false,
                    confirmButtonText: 'Update',
                    html:`
                        <form id="update_complete_task">
                            <div class="form-group">
                            <label style="float:left;">Title</label>
                            <input type="text" name="title" class="form-control mb-3" style="border:1px solid #ddd" value=${task.title}>
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Description</label>
                            <textarea name="description" col="10" row="1" class="form-control" style="border:1px solid #ddd">${task.description}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="d-flex">Members</label>
                                <select name="members[]" class="form-control select-member" style="border:1px solid #ddd" multiple>
                                    <option value=""></option>
                                    ${member_options}
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Start Date</label>
                                <input type="text" name="start_date" id="start_date" class="form-control" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label style="float:left;">Dead Line</label>
                                <input type="text" name="dead_line" id="dead_line" class="form-control" style="border:1px solid #ddd">
                            </div>
                            <div class="form-group">
                                <label class="d-flex">Description</label>
                                <select name="priority_id" class="form-control select-priority" style="border:1px solid #ddd">
                                    <option value=""></option>
                                    ${priority_options}
                                </select>
                            </div>
                        </form>
                        `,
                    }).then((result) => {
                        if (result.isConfirmed) {
                               var update_task_form = $('#update_complete_task').serialize();
                               $.ajax({
                                    url : `/task/${task.id}`,
                                    type : 'PUT',
                                    data : update_task_form,
                                    success : function(res){
                                       taskData();
                                    },
                               })
                           
                            }   
                        })

                    $('.select-priority').select2({
                        placeholder : '-- Please Choose (Priority) --',
                        allowClear : true,
                        theme : 'bootstrap4',
                    });

                    $('.select-member').select2({
                        placeholder : '-- Please Choose (Members) --',
                        allowClear : true,
                        theme : 'bootstrap4',
                    });

                    $('#start_date').daterangepicker({
                        "singleDatePicker": true,
                        "showDropdowns": true,
                        "autoApply": true,
                        "maxdate" : moment(),
                        "locale": {
                            "format": "YYYY-MM-DD",
                            }
                    });

                    $('#dead_line').daterangepicker({
                        "singleDatePicker": true,
                        "showDropdowns": true,
                        "autoApply": true,
                        "maxdate" : moment(),
                        "locale": {
                            "format": "YYYY-MM-DD",
                            }
                    });
                })

                // Delete Task
                $(document).on('click','.delete_pending_task',function(e){
                    e.preventDefault();
                    var id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure that you want to delete?',
                        showDenyButton: true,
                        confirmButtonText: 'Yes,delete',
                        denyButtonText: `No,keep it`,
                        reverseButtons : true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url : `/task/${id}`,
                                    type : 'DELETE',
                                    success : function(){
                                        taskData();
                                    }
                                })
                            } 
                        })
                })

                $(document).on('click','.delete_inprogress_task',function(e){
                    e.preventDefault();
                    var id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure that you want to delete?',
                        showDenyButton: true,
                        confirmButtonText: 'Yes,delete',
                        denyButtonText: `No,keep it`,
                        reverseButtons : true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url : `/task/${id}`,
                                    type : 'DELETE',
                                    success : function(){
                                        taskData();
                                    }
                                })
                            } 
                        })
                })

                $(document).on('click','.delete_complete_task',function(e){
                    e.preventDefault();
                    var id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure that you want to delete?',
                        showDenyButton: true,
                        confirmButtonText: 'Yes,delete',
                        denyButtonText: `No,keep it`,
                        reverseButtons : true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url : `/task/${id}`,
                                    type : 'DELETE',
                                    success : function(){
                                        taskData();
                                    }
                                })
                            } 
                        })
                })
    
            })

        </script>
    </x-slot>
</x-layout>