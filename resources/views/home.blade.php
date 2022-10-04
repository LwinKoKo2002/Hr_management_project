<x-layout>
    <x-slot name="title">
        Home
    </x-slot>
    <div class="container profile">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 profile-image-container">
                                <img src="{{$employee->profile_image_path()}}" alt="profile-image"
                                    class="profile-image">
                                <div class="profile-image-text">
                                    <h5>{{$employee->name}}</h5>
                                    <h6 class="text-muted">{{$employee->employee_id}} | <span
                                            class="text-success">{{$employee->phone}}</span></h6>
                                    <p class="text-white badge badge-pill badge-secondary mb-2">{{$employee->department
                                        ?
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
    </x-slot>
</x-layout>