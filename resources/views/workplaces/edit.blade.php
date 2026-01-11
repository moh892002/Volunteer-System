<x-dashboard.layout>
    <x-slot:title>Edit Workplace</x-slot:title>

    <div class="w-75 mx-auto mt-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h1 class="">Edit Workplace</h1>

            <a class="btn btn-secondary p-2 mx-start" href="{{ route('workplaces.index') }}">
                <i class="fas fa-arrow-left"></i> all workplaces</a>
        </div>

        <form class="row" action="{{ route('workplace.update', $workplace->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('put')

            <x-input type='text' name='name' label='Name' value='{{ $workplace->name }}' />
            <x-input type='email' name='email' label='Email' value='{{ $workplace->email }}' />
            <x-input type='text' name='address' label='Address' value='{{ $workplace->address }}' />
            <x-input type='text' name='phone' label='Phone' value='{{ $workplace->phone }}' />
            <x-input type='text' name='description' label='Description' value='{{ $workplace->description }}' />

            <div class="mb-1">
                <button type="submit" class="btn btn-success w-100">Update</button>
            </div>
        </form>

    </div>

</x-dashboard.layout>
