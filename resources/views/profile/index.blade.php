<x-layout>
    <x-slot name="title">
        Profile
    </x-slot>
    <div class="container profile">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 profile-image-container">
                                <img src="{{$employee->profile_image_path()}}" alt="profile-image"
                                    class="profile-image">
                                <div class="profile-image-text">
                                    <h5>{{$employee->name}}</h5>
                                    <h6 class="text-muted">{{$employee->employee_id}} | <span
                                            class="text-success">{{$employee->phone}}</span></h6>
                                    <p class="text-white badge badge-pill badge-secondary mb-2">
                                        {{$employee->department ?
                                        $employee->department->name
                                        : '-'}}
                                    </p>
                                    <div class="role">
                                        @foreach ($roles as $role)
                                        <span class="text-white badge badge-pill badge-success">
                                            {{$role->name}}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 profile-information">
                                <h6>Gender : <span class="text-muted ml-1">{{$employee->gender}}</span></h6>
                                <h6>Phone : <span class="text-muted ml-1">{{$employee->phone}}</span></h6>
                                <h6>Email : <span class="text-muted ml-1">{{$employee->email}}</span></h6>
                                <h6>Address : <span class="text-muted ml-1">{{$employee->address}}</span></h6>
                                <h6>Birthday : <span class="text-muted ml-1">{{$employee->birthday}}</span></h6>
                                <h6>Is Present? : @if ($employee->is_present == 1)
                                    <span class="badge badge-pill badge-success ml-1 p-1">Present</span>
                                    @else
                                    <span class="badge badge-pill badge-danger ml-1 p-1">Leave</span>
                                    @endif
                                </h6>
                                <h6>Date of join : <span class="text-muted ml-1">{{$employee->date_of_join}}</span></h6>
                                <h6>Nrc Number : <span class="text-muted ml-1">{{$employee->nrc_number}}</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card my-4">
                    <div class="card-body">
                        <button type="submit" id="logout" class="btn btn-theme btn-block m-0">Logout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            $(document).ready(function(){       
                $('#logout').click(function(e){
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure that you want to logout?',
                        showCancelButton: true,
                        confirmButtonText: 'Confirm',
                        reverseButtons : true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url : "{{route('logout')}}",
                                    type : 'POST',
                                    success : function(){
                                       window.location.reload();
                                    }
                                })
                            } 
                        })
                })
            })
        </script>
    </x-slot>
</x-layout>