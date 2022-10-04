<x-layout>
    <x-slot name="title">Permission</x-slot>
    <div class="datatable">
        <div class="button">
            @can('create_permission')
            <a href="{{route('permission.create')}}" class="btn btn-theme"> <i class="fa-solid fa-circle-plus "></i>
                Create New Permission </a>
            @endcan
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered " id="permission" width="100%">
                    <thead>
                        <th></th>
                        <th class="text-center">Name</th>
                        <th class="text-center no-search no-sort">Created at</th>
                        <th class="text-center no-search">Updated at</th>
                        <th class="text-center no-sort no-search">Action</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
              let datatable =   $('#permission').DataTable({
                    ajax: "{{route('permission.datatable.data')}}",
                    columns: [
                        {data : 'plus-icon' , name : 'plus-icon' , class : 'text-center' },
                        { data: 'name' , name: 'name', class : 'text-center'},
                        { data: 'created_at', name: 'created_at' , class : 'text-center'},
                        { data: 'updated_at', name: 'updated_at' , class : 'text-center'},
                        { data: 'action' , name: 'action', class : 'text-center'},
                    ],
                    "order": [
                        [ 3, 'desc' ]
                    ],
                });
                // Delete Btn
                $(document).on('click','.delete',function(e){
                    e.preventDefault();
                    var permission_id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure that you want to delete?',
                        showDenyButton: true,
                        confirmButtonText: 'Yes,delete',
                        denyButtonText: `No,keep it`,
                        reverseButtons : true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url : `/permission/${permission_id}`,
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