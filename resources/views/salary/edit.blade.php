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
                        <form action="{{route('salary.update',$salary->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <x-input_wrapper>
                                <x-label name="employee" />
                                <select name="user_id" class="form-control select-employee">
                                    <option value=""></option>
                                    @foreach ($employees as $employee)
                                    <option value="{{$employee->id}}" {{$employee->id
                                        == old('user_id',$salary->user_id) ? 'selected' : '-'}}>{{$employee->name}}
                                        ({{$employee->employee_id}})
                                    </option>
                                    @endforeach
                                </select>
                                <x-error name="user_id" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="month" />
                                <select name="month_id" class="form-control select-month">
                                    <option value=""></option>
                                    @foreach ($months as $month)
                                    <option value="{{$month->id}}" {{$month->id
                                        == old('month_id',$salary->month_id) ? 'selected' : '-'}}>{{$month->name}}
                                    </option>
                                    @endforeach
                                </select>
                                <x-error name="month_id" />
                            </x-input_wrapper>
                            <x-input_wrapper>
                                <x-label name="year" />
                                <select name="year" class="form-control" id=" select-year">
                                    <option value=""></option>
                                    @for ($i = 0; $i < 11 ; $i++) <option
                                        value="{{now()->addYears(5)->subYear($i)->format('Y')}}" @if(now()->
                                        addYears(5)->
                                        format('Y') == now()->addYears(5)->subYear($i)->format('Y') ||
                                        now()->addYears(5)->subYear($i)->format('Y') == $salary->year)
                                        selected
                                        @endif >
                                        {{now()->addYears(5)->subYear($i)->format('Y')}}
                                        </option>
                                        @endfor
                                </select>
                                <x-error name="year" />
                            </x-input_wrapper>
                            <x-input name="amount" type="number" value="{{$salary->amount}}" />
                            <button class="btn btn-theme btn-block" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('.select-employee').select2({
                    placeholder : '-- Please Choose Employee --',
                    allowClear : true,
                    theme : 'bootstrap4',
                });

                $('.select-month').select2({
                    placeholder : '-- Please Choose (Month) --',
                    allowClear : true,
                    theme : 'bootstrap4',
                });

                $('# select-year').select2({
                    placeholder : '-- Please Choose (Year) --',
                    allowClear : true,
                    theme : 'bootstrap4',
                });
            });
        </script>
    </x-slot>
</x-layout>