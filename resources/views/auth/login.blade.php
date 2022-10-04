<x-layout>
    <x-slot name="title">
        Login
    </x-slot>
    <div class="container login-form">
        <div class="row justify-content-center align-items-center" style="height:75vh;">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('login')}}" method="POST">
                            @csrf
                            <h5>LOGIN</h5>
                            <p class="text-black-50 mb-4">Please fill the login form.</p>
                            <x-input name="phone" type="number" />
                            <x-input name="password" type="password" />
                            <button type=" submit" class="btn btn-theme btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
    </x-slot>
</x-layout>