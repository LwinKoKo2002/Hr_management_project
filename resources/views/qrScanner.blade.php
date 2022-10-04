<x-layout>
    <x-slot name="title">
        Attendance Scanner
    </x-slot>
    <div class="qr-scanner text-center">
        <div class="card mb-4">
            <div class="card-body text-center">
                @error('fail')
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
                @enderror
                <div class="row">
                    <div class="col-lg-12 profile-image-container">
                        <img src="{{asset('/images/qr-scanner.svg')}}" alt="qr-scanner" width="300px">
                        <p>Please Scan Attendance QR</p>
                        <!-- Button trigger modal -->
                        <button class="btn btn-theme" type="submit" data-toggle="modal"
                            data-target="#scanModal">Scan</button>
                        <!-- Modal -->
                        <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scannerModal"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="scannerModal">Attendance Scaner</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <video id="scanner" width="280px"></video>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-theme" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-lg-4 col-12 mb-3">
                        <select name="month" id="select-month" class="form-control select-month">
                            <option value=""></option>
                            <option value="1" @if (now()->format('m') == '1')
                                selected @endif class="text-left">Jan</option>
                            <option value="2" @if (now()->format('m') == '2')
                                selected @endif class="text-left">Feb</option>
                            <option value="3" @if (now()->format('m') == '3')
                                selected @endif class="text-left">Mar</option>
                            <option value="4" @if (now()->format('m') == '4')
                                selected @endif class="text-left">Apr</option>
                            <option value="5" @if (now()->format('m') == '5')
                                selected @endif class="text-left">May</option>
                            <option value="6" @if (now()->format('m') == '6')
                                selected @endif class="text-left">Jun</option>
                            <option value="7" @if (now()->format('m') == '7')
                                selected @endif class="text-left">Jul</option>
                            <option value="8" @if (now()->format('m') == '8')
                                selected @endif class="text-left">Aug</option>
                            <option value="9" @if (now()->format('m') == '9')
                                selected @endif class="text-left">Sep</option>
                            <option value="10" @if (now()->format('m') == '10')
                                selected @endif class="text-left">Oct</option>
                            <option value="11" @if (now()->format('m') == '11')
                                selected @endif class="text-left">Nov</option>
                            <option value="12" @if (now()->format('m') == '12')
                                selected @endif class="text-left">Dec</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-12 mb-3">
                        <select name="year" id="select-year" class="form-control select-year">
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
                    <div class="col-lg-4 col-12 mb-3">
                        <button class="btn btn-theme btn-block m-0 shadow-0" style="padding: 8px;" id="search"><i
                                class="fa-solid fa-magnifying-glass"></i> Search</button>
                    </div>
                </div>
                <h6 class="text-left mb-4 font-bold">Attendance Overview</h6>
                <div class="attendance_overview_table mb-4"></div>
                <h6 class="text-left mb-4 font-bold">Salary Overview</h6>
                <div class="salary_overview_table mb-4"></div>
                <h6 class="text-left mb-4 font-bold">Attendance Records</h6>
                <table class="table table-bordered mt-4" id="attendence" width="100%">
                    <thead>
                        <th></th>
                        <th class="text-center">Employee</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Checkin Time</th>
                        <th class="text-center">Checkout Time</th>
                        <th class="text-center hidden no-search">Updated at</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            const videoElem = document.getElementById('scanner');
            const qrScanner = new QrScanner(videoElem,result => {
                if(result){
                    $.ajax({
                        url : `/chekin-checkout/scanner?value=${result}`,
                        type : 'POST',
                        success : function(res){
                            if(res.status == 'success'){
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                                Toast.fire({
                                    icon: 'success',
                                    title: res.message
                                })
                        }else if(res.status == 'fail'){
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                                Toast.fire({
                                    icon: 'error',
                                    title: res.message
                                })
                        }   
                        }
                    })
                    $('#scanModal').modal('hide')
                    qrScanner.stop();
                }
            });

            $('#scanModal').on('shown.bs.modal', function (event) {
                qrScanner.start();
            })

            $('#scanModal').on('hidden.bs.modal', function (event) {
                qrScanner.stop();
            })
           

            $(document).ready(function () {
              let datatable =   $('#attendence').DataTable({
                    ajax: "{{route('my-attendence.datatable.data')}}",
                    columns: [
                        { data : 'plus-icon' , name : 'plus-icon' , class : 'text-center' },
                        { data: 'employee' , name: 'employee', class : 'text-center'},
                        { data: 'date', name: 'date' , class: 'text-center'},
                        { data: 'checkin_time' , name: 'checkin_time' , class: 'text-center'},
                        { data: 'checkout_time' , name: 'checkout_time' , class: 'text-center'},
                        { data: 'updated_at', name: 'updated_at' , class : 'text-center'}
                    ],
                    "order": [
                        [ 5, 'desc' ]
                    ],
                });
                attendanceOverview();
                function attendanceOverview(){
                    var month = $('#select-month').val();
                    var year = $('#select-year').val();
                    $.ajax({
                        url: `/my-attendance/overview/table?month=${month}&year=${year}`,
                        type : 'GET',
                        success:function(res){
                            $('.attendance_overview_table').html(res);
                        }
                    });
                    $.ajax({
                        url: `/my-salary/overview/table?month=${month}&year=${year}`,
                        type : 'GET',
                        success:function(res){
                            $('.salary_overview_table').html(res);
                        }
                    });

                    datatable.ajax.url(`/my-attendence/datatable/data?month=${month}&year=${year}`).load();
                }

                function attendanceRecords(){
                    var month = $('#select-month').val();
                    var year = $('#select-year').val();
                 
                }

                $('#search').on('click',function(event){
                    event.preventDefault();
                    attendanceOverview();
                })
        });
                 $('.select-month').select2({
                    placeholder : '-- Please Choose (Month) --',
                    allowClear : true,
                    theme : 'bootstrap4',
                });

                $('.select-year').select2({
                    placeholder : '-- Please Choose (Year) --',
                    allowClear : true,
                    theme : 'bootstrap4',
                });
        </script>
    </x-slot>
</x-layout>