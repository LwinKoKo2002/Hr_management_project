<x-layout>
    <x-slot name="title">
        Create New Project
    </x-slot>
    <div class="employee-form">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('project.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <x-input name="title" />
                            <x-input_wrapper>
                                <x-label name="description" />
                                <textarea name="description" cols="30" rows="4"
                                    class="form-control">{{old('description')}}</textarea>
                                <x-error name="description" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="start_date" />
                                <input type="text" name="start_date" id="start_date" class="form-control"
                                    value="{{old('start_date')}}">
                                <x-error name="start_date" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="dead_line" />
                                <input type="text" name="dead_line" id="deadline" class="form-control"
                                    value="{{old('dead_line')}}">
                                <x-error name="dead_line" />
                            </x-input_wrapper>
                            <x-input_wrapper class="profile">
                                <x-label name="image (only png , jpg , jpeg)" />
                                <input type="file" name="images[]" class="form-control" id="images" autocomplete="off"
                                    multiple accept="image/.png,.jpg,.jpeg">
                                <x-error name="images" />
                            </x-input_wrapper>
                            <div class="preview-img" id="preview_images"></div>
                            <x-input_wrapper class="profile">
                                <x-label name="file (only pdf)" />
                                <input type="file" name="files[]" class="form-control" id="files" autocomplete="off"
                                    multiple accept="application/pdf">
                                <x-error name="files" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="project_leader" />
                                <select name="leaders[]" class="form-control select-leader" multiple>
                                    <option value=""></option>
                                    @foreach ($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->name}}
                                        ({{$employee->employee_id}})
                                    </option>
                                    @endforeach
                                </select>
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="project_member" />
                                <select name="members[]" class="form-control select-member" multiple>
                                    <option value=""></option>
                                    @foreach ($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->name}}
                                        ({{$employee->employee_id}})
                                    </option>
                                    @endforeach
                                </select>
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="priority" />
                                <select name="priority_id" class="form-control select-priority">
                                    <option value=""></option>
                                    @foreach ($priorities as $priority)
                                    <option value="{{$priority->id}}" {{$priority->id
                                        == old('priority_id') ? 'selected' : '-'}}>{{$priority->name}}
                                    </option>
                                    @endforeach
                                </select>
                                <x-error name="priority_id" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="status" />
                                <select name="status_id" class="form-control select-status">
                                    <option value=""></option>
                                    @foreach ($statuses as $status)
                                    <option value="{{$status->id}}" {{$status->id
                                        == old('status_id') ? 'selected' : '-'}}>{{$status->name}}
                                    </option>
                                    @endforeach
                                </select>
                                <x-error name="status_id" />
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
            $(document).ready(function() {
                
                $('#images').on('change',function(){
                    var select_img = document.querySelector('#images');
                    var images = select_img.files;
                    for(let i = 0 ; i<images.length ; i++){
                        $('#preview_images').append(`<img src="${URL.createObjectURL(images[i])}" class="thumbnail" alt="profile_img"/>`);
                    }
                })


                $('.select-priority').select2({
                    placeholder : '-- Please Choose (Priority) --',
                    allowClear : true,
                    theme : 'bootstrap4',
                });

                $('.select-status').select2({
                    placeholder : '-- Please Choose (Status) --',
                    allowClear : true,
                    theme : 'bootstrap4',
                });

                $('.select-leader').select2({
                    allowClear : true,
                    theme : 'bootstrap4',
                });

                $('.select-member').select2({
                    allowClear : true,
                    theme : 'bootstrap4',
                });


                $('#start_date').daterangepicker({
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "autoApply": true,
                    "maxdate" : moment(),
                    "locale": {
                        "format": "YYYY-MM-DD",
                        }
                });

                $('#deadline').daterangepicker({
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "autoApply": true,
                    "maxdate" : moment(),
                    "locale": {
                        "format": "YYYY-MM-DD",
                        }
                });
            });
        </script>
    </x-slot>
</x-layout>