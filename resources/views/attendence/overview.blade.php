<x-layout>
    <x-slot name="title">Attendance Overview</x-slot>
    <div class="attendance-overview">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-lg-3 col-12 mb-3">
                        <input type="text" name="employee" class="form-control" id="employee" placeholder="employee">
                    </div>
                    <div class="col-lg-3 col-12 mb-3">
                        <select name="month" id="select-month" class="form-control">
                            <option value=""></option>
                            <option value="01" @if (now()->format('m') == '01')
                                selected @endif>Jan</option>
                            <option value="02" @if (now()->format('m') == '02')
                                selected @endif>Feb</option>
                            <option value="03" @if (now()->format('m') == '03')
                                selected @endif>Mar</option>
                            <option value="04" @if (now()->format('m') == '04')
                                selected @endif>Apr</option>
                            <option value="05" @if (now()->format('m') == '05')
                                selected @endif>May</option>
                            <option value="06" @if (now()->format('m') == '06')
                                selected @endif>Jun</option>
                            <option value="07" @if (now()->format('m') == '07')
                                selected @endif>Jul</option>
                            <option value="08" @if (now()->format('m') == '08')
                                selected @endif>Aug</option>
                            <option value="09" @if (now()->format('m') == '09')
                                selected @endif>Sep</option>
                            <option value="10" @if (now()->format('m') == '10')
                                selected @endif>Oct</option>
                            <option value="11" @if (now()->format('m') == '11')
                                selected @endif>Nov</option>
                            <option value="12" @if (now()->format('m') == '12')
                                selected @endif>Dec</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-12 mb-3">
                        <select name="year" id="select-year" class="form-control">
                            <option value=""></option>
                            @for ($i = 0; $i < 5 ; $i++) <option value="{{now()->subYear($i)->format('Y')}}" @if(now()->
                                format('Y') == now()->subYear($i)->format('Y'))
                                selected
                                @endif>
                                {{now()->subYear($i)->format('Y')}}
                                </option>
                                @endfor
                        </select>
                    </div>
                    <div class="col-lg-3 col-12 mb-3">
                        <button class="btn btn-theme btn-block m-0 shadow-0" style="padding: 8px;" id="search"><i
                                class="fa-solid fa-magnifying-glass"></i> Search</button>
                    </div>
                </div>
                <div class="attendance_overview_table"></div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $("#select-month").select2({
                placeholder: "-- Please Choose (month) --",
                allowClear: true,
                theme: "bootstrap4"
                });

                $("#select-year").select2({
                placeholder: "-- Please Choose (year) --",
                allowClear: true,
                theme: "bootstrap4"
                });
                attendanceOverview();
                function attendanceOverview(){
                    var employee = $('#employee').val();
                    var month = $('#select-month').val();
                    var year = $('#select-year').val();
                    $.ajax({
                        url: `/attendance/overview/table?employee=${employee}&month=${month}&year=${year}`,
                        type : 'GET',
                        success:function(res){
                            $('.attendance_overview_table').html(res);
                        }
                    });
                }
                $('#search').on('click',function(event){
                    event.preventDefault();
                    attendanceOverview();
                })
        </script>
    </x-slot>
</x-layout>