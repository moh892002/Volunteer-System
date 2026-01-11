<x-dashboard.layout>
    <x-slot:title>Create New Workplace</x-slot:title>
    <div class="w-75 mx-auto mt-5">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h1>Create new Workplace</h1>
            <a class="btn btn-secondary p-2" href="{{ route('workplaces.index') }}">
                <i class="fas fa-arrow-left"></i> All Workplaces
            </a>
        </div>
        <form method="POST" action="{{ route('workplace.store') }}" class="row">
            @csrf
            <x-input name="name" label="Name" class="form-control" type="text" />
            <x-input name="email" label="Email" class="form-control" type="email" />
            <x-input name="address" label="Address" class="form-control" type="text" />
            <x-input name="phone" label="Phone" class="form-control" type="text" />
            <x-input name="description" label="Description" class="form-control" type="text" />

            <div class="mb-1">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Create</button>
            </div>
        </form>
    </div>
</x-dashboard.layout>
