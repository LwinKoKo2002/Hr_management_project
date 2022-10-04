<x-layout>
    <x-slot name="title">
        Create New Employee
    </x-slot>
    <div class="employee-form">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('employee.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <x-input name="employee_id" />
                            <x-input name="name" />
                            <x-input name="email" type="email" />
                            <x-input name="phone" type="number" />
                            <x-input name="pin_code" type="number" />
                            <x-input name="password" type="password" />
                            <x-input_wrapper>
                                <x-label name="department" />
                                <select name="department_id" class="form-control">
                                    @foreach ($departments as $department)
                                    <option value="{{$department->id}}" {{$department->id
                                        == old('department_id') ? 'selected' : '-'}}>{{$department->name}}
                                    </option>
                                    @endforeach
                                </select>
                                <x-error name="department_id" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="role" />
                                <select name="roles[]" class="form-control select-two" multiple>
                                    @foreach ($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                <x-error name="roles" />
                            </x-input_wrapper>
                            <x-input_wrapper class="profile">
                                <x-label name="profile_img" />
                                <input type="file" name="profile_img" class="form-control" id="profile_img"
                                    autocomplete="off" multiple>
                                <x-error name="profile_img" />
                            </x-input_wrapper>
                            <div class="preview-img" id="preview_img"></div>
                            <x-input_wrapper>
                                <x-label name="address" />
                                <textarea name="address" cols="30" rows="4"
                                    class="form-control">{{old('address')}}</textarea>
                                <x-error name="address" />
                            </x-input_wrapper>
                            <x-input name="nrc_number" vale="nrc_number" />
                            <x-input_wrapper>
                                <x-label name="birthday" />
                                <input type="text" name="birthday" class="form-control" id="birthday" autocomplete="off"
                                    value="{{old('birthday')}}">
                                <x-error name="birthday" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="gender" />
                                <select name="gender" id="gender" class="form-control">
                                    <option value="male" {{old('gender')=="male" ? 'selected' : '-' }}>Male
                                    </option>
                                    <option value="female" {{old('gender')=="female" ? 'selected' : '-' }}>Female
                                    </option>
                                </select>
                                <x-error name="gender" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="is_present" />
                                <select name="is_present" class="form-control">
                                    <option value="1" {{old('is_present')==1 ? 'selected' : '-' }}>Present</option>
                                    <option value="0" {{old('is_present')==0 ? 'selected' : '-' }}>Leave</option>
                                </select>
                                <x-error name="is_present" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="date_of_join" />
                                <input type="text" name="date_of_join" class="form-control" id="date_of_join"
                                    autocomplete="off" value="{{old('date_of_join')}}">
                                <x-error name="date_of_join" />
                            </x-input_wrapper>
                            <button class="btn btn-theme btn-block" type="submit">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            $('#birthday').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "maxdate" : moment(),
                "locale": {
                    "format": "YYYY-MM-DD",
                    }
                });

                $('#date_of_join').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "maxdate" : moment(),
                "locale": {
                    "format": "YYYY-MM-DD",
                    }
                });

                $('#profile_img').on('change',function(){
                    var select_img = document.querySelector('#profile_img');
                    var profile_img = select_img.files;
                    for(let i = 0 ; i<profile_img.length ; i++){
                        $('#preview_img').append(`<img src="${URL.createObjectURL(profile_img[i])}" class="thumbnail" alt="profile_img"/>`);
                    }
                })

            $(document).ready(function() {
                $('.select-two').select2({
                    theme : 'bootstrap4',
                });
            });
        </script>
    </x-slot>
</x-layout>