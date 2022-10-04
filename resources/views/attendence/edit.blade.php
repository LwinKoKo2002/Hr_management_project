<x-layout>
    <x-slot name="title">
        Edit New Attendence
    </x-slot>
    <div class="employee-form">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @error('fail')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                        <form action="{{route('attendence.update',$attendence->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <x-input_wrapper>
                                <x-label name="Attendence" />
                                <select name="user_id" class="form-control select-two">
                                    <option value="">-- Select Employee --</option>
                                    @foreach ($employees as $employee)
                                    <option value="{{$employee->id}}" {{$employee->id
                                        == old('employee_id',$attendence->user_id) ? 'selected' :
                                        '-'}}>{{$employee->name}}
                                        ({{$employee->employee_id}})
                                    </option>
                                    @endforeach
                                </select>
                                <x-error name="user_id" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="date" />
                                <input type="text" name="date" id="date" class="form-control"
                                    value="{{old('date',$attendence->date)}}">
                                <x-error name="date" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="checkin_time" />
                                <input type="text" name="checkin_time" id="checkin_time" class="form-control"
                                    value="{{old('checkin_time',Carbon\Carbon::parse($attendence->checkin_time)->format('H:i:s'))}}">
                                <x-error name="checkin_time" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="checkout_time" />
                                <input type="text" name="checkout_time" id="checkout_time" class="form-control"
                                    value="{{old('checkout_time',Carbon\Carbon::parse($attendence->checkout_time)->format('H:i:s'))}}">
                                <x-error name="checkout_time" />
                            </x-input_wrapper>
                            <button class="btn btn-theme btn-block" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            $('#date').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "maxdate" : moment(),
                "locale": {
                    "format": "YYYY-MM-DD",
                    }
            });

            $('#checkin_time').daterangepicker({
                "singleDatePicker": true,
                "timePicker": true,
                "timePicker24Hour": true,
                "timePickerSeconds" : true,
                "autoApplay": true,
                "locale":{
                    "format": "HH:mm:ss",
                }
            }).on('show.daterangepicker', function(ev, picker) {
                picker.container.find('.calendar-table').hide();
            });;

            $('#checkout_time').daterangepicker({
                "singleDatePicker": true,
                "timePicker": true,
                "timePicker24Hour": true,
                "timePickerSeconds" : true,
                "autoApplay": true,
                "locale":{
                    "format": "HH:mm:ss",
                }
            }).on('show.daterangepicker', function(ev, picker) {
                picker.container.find('.calendar-table').hide();
            });;

            $(document).ready(function() {
                $('.select-two').select2({
                    theme : 'bootstrap4',
                });
             });
        </script>
    </x-slot>
</x-layout>