<x-layout>
    <x-slot name="title">
        Edit Department
    </x-slot>
    <div class="employee-form">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('department.update',$department->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <x-input name="name" value="{{$department->name}}" />
                            <button class="btn btn-theme btn-block" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
    </x-slot>
</x-layout>