<x-layout>
    <x-slot name="title">
        Edit Company Setting
    </x-slot>
    <div class="employee-form">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('company-setting.update',$company_setting->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <x-input name="company_name" value="{{$company_setting->company_name}}" />
                            <x-input name="company_email" value="{{$company_setting->company_email}}" type="email" />
                            <x-input name="company_phone" value="{{$company_setting->company_phone}}" type="number" />
                            <x-input_wrapper>
                                <x-label name="address" />
                                <textarea name="company_address" cols="30" rows="4"
                                    class="form-control">{{old('company_address',$company_setting->company_address)}}</textarea>
                                <x-error name="company_address" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="company_start_time" />
                                <input type="text" name="company_start_time" class="form-control"
                                    id="company_start_time" autocomplete="off"
                                    value="{{old('company_start_time',$company_setting->company_start_time)}}">
                                <x-error name="company_start_time" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="company_end_time" />
                                <input type="text" name="company_end_time" class="form-control" id="company_end_time"
                                    autocomplete="off"
                                    value="{{old('company_end_time',$company_setting->company_end_time)}}">
                                <x-error name="company_end_time" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="break_start_time" />
                                <input type="text" name="break_start_time" class="form-control" id="brake_start_time"
                                    autocomplete="off"
                                    value="{{old('break_start_time',$company_setting->break_start_time)}}">
                                <x-error name="break_start_time" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="break_end_time" />
                                <input type="text" name="break_end_time" class="form-control" id="brake_end_time"
                                    autocomplete="off"
                                    value="{{old('break_end_time',$company_setting->break_end_time)}}">
                                <x-error name="break_end_time" />
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
            $('#company_start_time').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds" : true,
            "autoApplay": true,
            "locale":{
                "format": "HH:mm:ss",
            }
        }).on('show.daterangepicker', function(ev, picker) {
            $('.calendar-table').hide();
        });;

        $('#company_end_time').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds" : true,
            "autoApplay": true,
            "locale":{
                "format": "HH:mm:ss",
            }
        }).on('show.daterangepicker', function(ev, picker) {
            $('.calendar-table').hide();
        });;
        
        $('#brake_start_time').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds" : true,
            "autoApplay": true,
            "locale":{
                "format": "HH:mm:ss",
            }
        }).on('show.daterangepicker', function(ev, picker) {
            $('.calendar-table').hide();
        });;

        $('#brake_end_time').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds" : true,
            "autoApplay": true,
            "locale":{
                "format": "HH:mm:ss",
            }
        }).on('show.daterangepicker', function(ev, picker) {
            $('.calendar-table').hide();
        });;
        </script>
    </x-slot>
</x-layout>