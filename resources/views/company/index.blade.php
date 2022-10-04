<x-layout>
    <x-slot name="title">
        Company Setting
    </x-slot>
    <div class="container company-setting">
        <div class="row justify-content-center">
            @foreach ($settings as $setting)
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 ">
                                <div class="company-name mb-4">
                                    <h5>Company Name</h5>
                                    <p class="text-muted">{{$setting->company_name}}</p>
                                </div>
                                <div class="company-phone mb-4">
                                    <h5>Company Phone</h5>
                                    <p class="text-muted">{{$setting->company_phone}}</p>
                                </div>
                                <div class="company-email mb-4">
                                    <h5>Company Email</h5>
                                    <p class="text-muted">{{$setting->company_email}}</p>
                                </div>
                                <div class="company-address mb-4">
                                    <h5>Company Address</h5>
                                    <p class="text-muted">{{$setting->company_address}}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="company-start-time mb-4">
                                    <h5>Company Start Time</h5>
                                    <p class="text-muted">{{$setting->company_start_time}}</p>
                                </div>
                                <div class="company-end-time mb-4">
                                    <h5>Company End Time</h5>
                                    <p class="text-muted">{{$setting->company_end_time}}</p>
                                </div>
                                <div class="break-start-time mb-4">
                                    <h5>Break Start Time</h5>
                                    <p class="text-muted">{{$setting->break_start_time}}</p>
                                </div>
                                <div class="break-end-time mb-4">
                                    <h5>Break End Time</h5>
                                    <p class="text-muted">{{$setting->break_end_time}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @can('edit_company_setting')
                <div class="card my-4">
                    <div class="card-body">
                        <a id="logout" class="btn btn-warning text-white btn-block m-0"
                            href="{{route('company-setting.edit',$setting->id)}}"><i
                                class="fa-sharp fa-solid fa-right-from-bracket"></i> Edit Company
                            Setting</a>
                    </div>
                </div>
                @endcan
            </div>
            @endforeach
        </div>
    </div>
    <x-slot name="script">
        <script>
        </script>
    </x-slot>
</x-layout>