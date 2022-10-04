<x-layout>
    <x-slot name="title"> Employees</x-slot>
    <div class="datatable">
        <div class="button">
            @can('create_employee')
            <a href="{{route('employee.create')}}" class="btn btn-theme"> <i class="fa-solid fa-circle-plus "></i>
                Create New Employee</a>
            @endcan
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered " id="employee" width="100%">
                    <thead>
                        <th></th>
                        <th class="text-center no-sort no-search">Profile</th>
                        <th class="text-center">Employee ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Phone</th>
                        <th class="text-center">Role (or) Designation</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Is Present</th>
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
              let datatable =   $('#employee').DataTable({
                    ajax: "{{route('datatable.data')}}",
                    columns: [
                        {data : 'plus-icon' , name : 'plus-icon' , class : 'text-center' },
                        {data : 'profile_image' , name : 'profile_image' ,class : 'text-center'},
                        { data: 'employee_id', name: 'employee_id', class : 'text-center'},
                        { data: 'name', name: 'name', class : 'text-center'},
                        { data: 'email', name: 'email', class : 'text-center' },
                        { data: 'phone' , name: 'phone', class : 'text-center'},
                        { data: 'role' , name: 'role', class : 'text-center'},
                        { data: 'department' , name: 'department', class : 'text-center'},
                        { data: 'is_present' , name: 'is_present', class : 'text-center'},
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
                    var employee_id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure that you want to delete?',
                        showDenyButton: true,
                        confirmButtonText: 'Yes,delete',
                        denyButtonText: `No,keep it`,
                        reverseButtons : true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url : `/employee/${employee_id}`,
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