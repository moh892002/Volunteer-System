<x-dashboard.layout>
    <x-slot:title>Edit Volunteer</x-slot:title>

    <div class="w-75 mx-auto mt-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h1 class="">Edit Volunteer</h1>

            <a class="btn btn-secondary p-2 mx-start" href="{{ route('volunteers.store') }}">
                <i class="fas fa-arrow-left"></i> all volunteers</a>
        </div>


        <form class="row" action="{{ route('volunteers.update', $volunteer->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('put')

            <x-input type='text' name='name' label='name' hint='name' class="col-md-6"
                value='{{ $volunteer->name }}' />
            <x-input type='email' name='email' label='email' class="col-md-6" value='{{ $volunteer->email }}' />
            <x-input type='text' name='phone' label='phone' hint='phone' class="col-md-6"
                value='{{ $volunteer->phone }}' />
            <x-input type='text' name='skills' label='skills' hint='skills' class="col-md-6"
                value='{{ $volunteer->skills }}' />

            <div class="mb-1">
                <button type="submit" class="btn btn-success w-100">Update</button>
            </div>
        </form>

    </div>

</x-dashboard.layout>
