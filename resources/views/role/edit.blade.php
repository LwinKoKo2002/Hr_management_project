<x-layout>
    <x-slot name="title">
        Edit Role
    </x-slot>
    <div class="employee-form">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('roles.update',$role->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <x-input name="name" value="{{$role->name}}" />
                            <x-label name="permission" />
                            <div class="row mt-2">
                                @foreach ($permissions as $permission)
                                <div class="col-md-4 col-6">
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" name="permissions[]"
                                            id="checkbox_{{$permission->id}}" value="{{$permission->name}}"
                                            @if(in_array($permission->id,$old_permissions)) checked
                                        @endif>
                                        <label class="form-check-label"
                                            for="checkbox_{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
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