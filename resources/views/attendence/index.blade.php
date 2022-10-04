<x-layout>
    <x-slot name="title">Attendence</x-slot>
    <div class="datatable">
        <div class="button">
            @can('create_attendence')
            <a href="{{route('attendence.create')}}" class="btn btn-theme"> <i class="fa-solid fa-circle-plus "></i>
                Attendence Create</a>
            @endcan
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered " id="attendence" width="100%">
                    <thead>
                        <th></th>
                        <th class="text-center">Employee</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Checkin Time</th>
                        <th class="text-center">Checkout Time</th>
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
              let datatable =   $('#attendence').DataTable({
                    ajax: "{{route('attendence.datatable.data')}}",
                    columns: [
                        { data : 'plus-icon' , name : 'plus-icon' , class : 'text-center' },
                        { data: 'employee' , name: 'employee', class : 'text-center'},
                        { data: 'date', name: 'date' , class: 'text-center'},
                        { data: 'checkin_time' , name: 'checkin_time' , class: 'text-center'},
                        { data: 'checkout_time' , name: 'checkout_time' , class: 'text-center'},
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
                    var attendence_id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure that you want to delete?',
                        showDenyButton: true,
                        confirmButtonText: 'Yes,delete',
                        denyButtonText: `No,keep it`,
                        reverseButtons : true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url : `/attendence/${attendence_id}`,
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