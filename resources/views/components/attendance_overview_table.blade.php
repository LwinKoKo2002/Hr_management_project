<table class="table table-bordered table-responsive table-striped" id="employee" width="100%">
    <thead>
        <th class="text-center">Employee</th>
        @foreach ($periods as $period)
        <th
            class="text-center @if($period->format('D') == 'Sat' || $period->format('D') == 'Sun')  alert-danger @endif">
            {{$period->format('d')}}<br>
            {{$period->format('D')}}</th>
        @endforeach
    </thead>
    <tbody>
        @foreach ($employees as $employee)
        <tr>
            <td class="text-center">{{$employee->name}}</td>
            @foreach ($periods as $period)
            @php
            $company_start_time = $period->format('Y-m-d'). ' ' .$setting->company_start_time;
            $company_end_time = $period->format('Y-m-d'). ' ' .$setting->company_end_time;
            $break_start_time = $period->format('Y-m-d'). ' ' .$setting->break_start_time;
            $break_end_time = $period->format('Y-m-d'). ' ' .$setting->break_end_time;
            $checkin_icon = '';
            $checkout_icon = '';
            $absent = '';
            $attendance =
            collect($attendances)->where('user_id',$employee->id)->where('date',$period->format('Y-m-d'))->first();
            if ($attendance) {
            if($attendance->checkin_time < $company_start_time){
                $checkin_icon='<i class="fa-solid fa-circle-check text-success"></i>' ; }else if($attendance->
                checkin_time > $company_start_time && $attendance->checkin_time < $break_start_time){
                    $checkin_icon='<i class="fa-solid fa-circle-check text-warning"></i>' ; }else{
                    $checkin_icon='<i class="fa-solid fa-circle-xmark text-danger"></i>' ; } if($attendance->
                    checkout_time < $break_end_time){
                        $checkout_icon='<i class="fa-solid fa-circle-xmark text-danger"></i>' ; }else if($attendance->
                        checkout_time > $break_end_time && $attendance->checkout_time
                        < $company_end_time){ $checkout_icon='<i class="fa-solid fa-circle-check text-warning"></i>' ;
                            }else{ $checkout_icon='<i class="fa-solid fa-circle-check text-success"></i>' ; } }else{
                            $absent="" ; } @endphp <td
                            class="text-center  @if($period->format('D') == 'Sat' || $period->format('D') == 'Sun')  alert-danger @endif">
                            <div>{!!$checkin_icon!!}</div>
                            <div>{!!$checkout_icon !!}</div>
                            <div style="font-size: 16px;vertical-align:middle;">{!!$absent!!}</div>
                            </td>
                            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>