<x-dashboard.layout>
    <x-slot:title>Volunteers</x-slot:title>
    {{-- <h1 class="h3 mb-4 text-gray-800">Volunteers</h1> --}}
    {{-- content here --}}
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h1>All Volunteers</h1>
        <a class="btn btn-secondary p-2" href="{{ route('volunteers.create') }}">
            <i class="fas fa-plus"></i> Add new volunteer
        </a>
    </div>
    <table class="w-100 table table-hover text-center">
        <thead class="table-primary">
            <tr>
                <th class="p-3">ID</th>
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3">Phone</th>
                <th class="p-3">Skills</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>


            @forelse ($volunteers as $volunteer)
                <tr class="align-middle">
                    <td class="p-3">{{ $volunteer->id }}</td>
                    <td class="p-3">{{ $volunteer->name }}</td>
                    <td class="p-3">{{ $volunteer->email }}</td>
                    <td class="p-3">{{ $volunteer->phone }}</td>
                    <td class="p-3">{{ $volunteer->skills }}</td>
                    <td>
                        @if (Auth::user()->isAdmin())
                            <form action="{{ route('volunteers.destroy', $volunteer->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <a href="{{ route('volunteers.edit', $volunteer->id) }}" class="btn btn-primary"><i
                                        class="fas fa-edit"></i></a>
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        @else
                            <span class="text-muted">View Only</span>
                        @endif
                    </td>
                </tr>
            @empty
                <td class="p-3" colspan="6">No volunteers found</td>
            @endforelse



        </tbody>
    </table>
</x-dashboard.layout>
