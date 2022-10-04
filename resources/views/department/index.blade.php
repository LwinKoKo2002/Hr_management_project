<x-layout>
    <x-slot name="title"> Department</x-slot>
    <div class="datatable">
        <div class="button">
            @can('create_department')
            <a href="{{route('department.create')}}" class="btn btn-theme"> <i class="fa-solid fa-circle-plus "></i>
                Department Create</a>
            @endcan
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered " id="department" width="100%">
                    <thead>
                        <th></th>
                        <th class="text-center">Name</th>
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
              let datatable =   $('#department').DataTable({
                    ajax: "{{route('department.datatable.data')}}",
                    columns: [
                        {data : 'plus-icon' , name : 'plus-icon' , class : 'text-center' },
                        { data: 'name' , name: 'name', class : 'text-center'},
                        { data: 'action' , name: 'action', class : 'text-center'},
                        { data: 'updated_at', name: 'updated_at' , class : 'text-center'}
                    ],
                    "order": [
                        [ 3, 'desc' ]
                    ],
                });
                // Delete Btn
                $(document).on('click','.delete',function(e){
                    e.preventDefault();
                    var department_id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure that you want to delete?',
                        showDenyButton: true,
                        confirmButtonText: 'Yes,delete',
                        denyButtonText: `No,keep it`,
                        reverseButtons : true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url : `/department/${department_id}`,
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