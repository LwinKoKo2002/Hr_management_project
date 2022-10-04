<x-layout>
    <x-slot name="title">Salary</x-slot>
    <div class="datatable">
        <div class="button">
            @can('create_salary')
            <a href="{{route('salary.create')}}" class="btn btn-theme"> <i class="fa-solid fa-circle-plus "></i>
                Salary Create</a>
            @endcan
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered " id="salary" width="100%">
                    <thead>
                        <th></th>
                        <th class="text-center">Employee</th>
                        <th class="text-center">Month</th>
                        <th class="text-center">Year</th>
                        <th class="text-center">Amount (MMK)</th>
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
              let datatable =   $('#salary').DataTable({
                    ajax: "{{route('salary.datatable.data')}}",
                    columns: [
                        {data : 'plus-icon' , name : 'plus-icon' , class : 'text-center' },
                        { data: 'employee' , name: 'employee', class : 'text-center'},
                        { data: 'month' , name: 'month', class : 'text-center'},
                        { data: 'year' , name: 'year', class : 'text-center'},
                        { data: 'amount' , name: 'amount', class : 'text-center'},
                        { data: 'action' , name: 'action', class : 'text-center'},
                        { data: 'updated_at', name: 'updated_at' , class : 'text-center'}
                    ],
                    "order": [
                        [ 6, 'desc' ]
                    ],
                });
                // Delete Btn
                $(document).on('click','.delete',function(e){
                    e.preventDefault();
                    var salary_id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure that you want to delete?',
                        showDenyButton: true,
                        confirmButtonText: 'Yes,delete',
                        denyButtonText: `No,keep it`,
                        reverseButtons : true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url : `/salary/${salary_id}`,
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