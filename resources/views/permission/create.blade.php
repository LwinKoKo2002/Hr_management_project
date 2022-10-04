<x-layout>
    <x-slot name="title">
        Create New Permission
    </x-slot>
    <div class="employee-form">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('permission.store')}}" method="POST">
                            @csrf
                            <x-input name="name" />
                            <button class="btn btn-theme btn-block" type="submit">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
    </x-slot>
</x-layout>