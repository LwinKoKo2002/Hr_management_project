<x-layout>
    <x-slot name="title">Salary Overview</x-slot>
    <div class="salary-overview">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-lg-3 col-12 mb-3">
                        <input type="text" name="employee" class="form-control" id="employee" placeholder="employee">
                    </div>
                    <div class="col-lg-3 col-12 mb-3">
                        <select name="month" id="select-month" class="form-control">
                            <option value=""></option>
                            @foreach ($months as $month)
                            <option value="{{$month->id}}" @if (now()->format('m') == $month->id) selected @endif>
                                {{Illuminate\Support\Str::limit($month->name,3,'')}}</option>
                            @endforeach
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
                <div class="salary_overview_table"></div>
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
                salaryOverview();
                function salaryOverview(){
                    var employee = $('#employee').val();
                    var month = $('#select-month').val();
                    var year = $('#select-year').val();
                    $.ajax({
                        url: `/salary/overview/table?employee=${employee}&month=${month}&year=${year}`,
                        type : 'GET',
                        success:function(res){
                            $('.salary_overview_table').html(res);
                        }
                    });
                }
                $('#search').on('click',function(event){
                    event.preventDefault();
                    salaryOverview();
                })
        </script>
    </x-slot>
</x-layout>