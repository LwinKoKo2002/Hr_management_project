<div class="table-responsive">
    <table class="table table-bordered table-striped" id="employee" width="100%">
        <thead>
            <th class="text-center">Employee</th>
            <th class="text-center">Role</th>
            <th class="text-center">Days of Month</th>
            <th class="text-center">Working Day</th>
            <th class="text-center">Off Day</th>
            <th class="text-center">Attendance Day</th>
            <th class="text-center">Leave</th>
            <th class="text-center">Per Day (MMK)</th>
            <th class="text-center">Total (MMK)</th>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            @php
            $attendanceDays=0;
            $salary = collect($employee->salaries)->where('month_id',$month)->where('year',$year)->first();
            $perDay = $salary->amount / $workingDays;
            @endphp
            @foreach ($periods as $period)
            @php
            $company_start_time = $period->format('Y-m-d'). ' ' .$setting->company_start_time;
            $company_end_time = $period->format('Y-m-d'). ' ' .$setting->company_end_time;
            $break_start_time = $period->format('Y-m-d'). ' ' .$setting->break_start_time;
            $break_end_time = $period->format('Y-m-d'). ' ' .$setting->break_end_time;
            $attendance =
            collect($attendances)->where('user_id',$employee->id)->where('date',$period->format('Y-m-d'))->first();
            if ($attendance) {
            if($attendance->checkin_time < $company_start_time){ $attendanceDays +=0.5; }else if($attendance->
                checkin_time >
                $company_start_time && $attendance->checkin_time < $break_start_time){ $attendanceDays +=0.5 ; }else{
                    $attendanceDays +=0 ; } if($attendance->checkout_time < $break_end_time){ $attendanceDays +=0; ;
                        }else if($attendance->checkout_time > $break_end_time && $attendance->checkout_time
                        < $company_end_time){ $attendanceDays +=0.5 ; }else{ $attendanceDays +=0.5 ; } }@endphp
                            @endforeach <tr>
                            <td class="text-center">{{$employee->name}}</td>
                            <td class="text-center">{{implode(', ' , $employee->roles->pluck('name')->toArray())}}</td>
                            <td class="text-center">{{$dayInMonths}}</td>
                            <td class="text-center">{{$workingDays}}</td>
                            <td class="text-center">{{$offDays}}</td>
                            <td class="text-center">{{$attendanceDays}}</td>
                            <td class="text-center">{{$workingDays - $attendanceDays}}</td>
                            <td class="text-center">{{number_format($perDay)}}</td>
                            <td class="text-center">{{number_format($perDay * $attendanceDays)}}</td>
                            </tr>
                            @endforeach
        </tbody>
    </table>
</div>