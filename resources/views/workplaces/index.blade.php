<x-dashboard.layout>
    <x-slot:title>Workplaces</x-slot:title>
    {{-- <h1 class="h3 mb-4 text-gray-800">Workplaces</h1> --}}
    {{-- content here --}}
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h1>All Workplaces</h1>
        <a class="btn btn-secondary p-2" href="{{ route('workplace.create') }}">
            <i class="fas fa-plus"></i> Add new workplace
        </a>
    </div>
    <table class="w-100 table table-hover text-center">
        <thead class="table-primary">
            <tr>
                <th class="p-3">ID</th>
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3">Phone</th>
                <th class="p-3">Address</th>
                <th class="p-3">Description</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($workplaces as $workplace)
                <tr class="align-middle">
                    <td class="p-3">{{ $workplace->id }}</td>
                    <td class="p-3">{{ $workplace->name }}</td>
                    <td class="p-3">{{ $workplace->email }}</td>
                    <td class="p-3">{{ $workplace->phone }}</td>
                    <td class="p-3">{{ $workplace->address }}</td>
                    <td class="p-3">{{ $workplace->description }}</td>
                    <td>
                        <form action="{{ route('workplace.destroy', $workplace->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <a href="{{ route('workplace.edit', $workplace->id) }}" class="btn btn-primary"><i
                                    class="fas fa-edit"></i></a>
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <td class="p-3" colspan="7">No workplaces found</td>
            @endforelse
        </tbody>
    </table>
</x-dashboard.layout>
