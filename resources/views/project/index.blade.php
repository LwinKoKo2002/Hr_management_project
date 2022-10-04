<x-layout>
    <x-slot name="title">Project</x-slot>
    <div class="datatable">
        <div class="button">
            @can('create_project')
            <a href="{{route('project.create')}}" class="btn btn-theme"> <i class="fa-solid fa-circle-plus "></i>
                Create New Project</a>
            @endcan
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered " id="project" width="100%">
                    <thead>
                        <th></th>
                        <th class="text-center">title</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Leaders</th>
                        <th class="text-center">Members</th>
                        <th class="text-center no-search no-sort">Priority</th>
                        <th class="text-center no-search no-sort">Status</th>
                        <th class="text-center no-search no-sort">Start Date</th>
                        <th class="text-center no-search no-sort">Dead Line</th>
                        <th class="text-center no-sort no-search">Action</th>
                        <th class="text-center hidden no-search">Updated at</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
              let datatable =   $('#project').DataTable({
                    ajax: "{{route('project.datatable.data')}}",
                    columns: [
                        {data : 'plus-icon' , name : 'plus-icon' , class : 'text-center' },
                        { data: 'title' , name: 'title', class : 'text-center'},
                        { data: 'description' , name: 'description', class : 'text-center'},
                        { data: 'leaders' , name: 'leaders', class : 'text-center'},
                        { data: 'members' , name: 'members', class : 'text-center'},
                        { data: 'priority' , name: 'priority', class : 'text-center'},
                        { data: 'status' , name: 'status', class : 'text-center'},
                        { data: 'start_date' , name: 'start_date', class : 'text-center'},
                        { data: 'dead_line' , name: 'dead_line', class : 'text-center'},
                        { data: 'action' , name: 'action', class : 'text-center'},
                        { data: 'updated_at', name: 'updated_at' , class : 'text-center'}
                    ],
                    "order": [
                        [ 10, 'desc' ]
                    ],
                });
                // Delete Btn
                $(document).on('click','.delete',function(e){
                    e.preventDefault();
                    var project_id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure that you want to delete?',
                        showDenyButton: true,
                        confirmButtonText: 'Yes,delete',
                        denyButtonText: `No,keep it`,
                        reverseButtons : true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url : `/project/${project_id}`,
                                    type : 'DELETE',
                                    success : function(){
                                        datatable.ajax.reload();
                                    }
                                })
                            } 
                        })
                })
        });
        </script>
    </x-slot>
</x-layout>