<x-layout>
    <x-slot name="title">Role</x-slot>
    <div class="datatable">
        <div class="button">
            @can('create_role')
            <a href="{{route('roles.create')}}" class="btn btn-theme"> <i class="fa-solid fa-circle-plus "></i>
                Create New Role </a>
            @endcan
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered " id="role" width="100%">
                    <thead>
                        <th></th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Permission</th>
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
              let datatable =   $('#role').DataTable({
                    ajax: "{{route('roles.datatable.data')}}",
                    columns: [
                        {data : 'plus-icon' , name : 'plus-icon' , class : 'text-center' },
                        { data: 'name' , name: 'name', class : 'text-center'},
                        { data: 'permission' , name: 'permission', class: 'text-center'},
                        { data: 'action' , name: 'action', class : 'text-center'},
                        { data: 'updated_at', name: 'updated_at' , class : 'text-center'}
                    ],
                    "order": [
                        [ 4, 'desc' ]
                    ],
                });
                // Delete Btn
                $(document).on('click','.delete',function(e){
                    e.preventDefault();
                    var role_id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure that you want to delete?',
                        showDenyButton: true,
                        confirmButtonText: 'Yes,delete',
                        denyButtonText: `No,keep it`,
                        reverseButtons : true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url : `/roles/${role_id}`,
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