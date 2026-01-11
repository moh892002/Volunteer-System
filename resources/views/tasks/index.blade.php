<x-dashboard.layout>
    <x-slot:title>Tasks</x-slot:title>
    {{-- <h1 class="h3 mb-4 text-gray-800">Tasks</h1> --}}
    {{-- content here --}}
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h1>All Tasks</h1>
        <a class="btn btn-secondary p-2" href="{{ route('tasks.create') }}">
            <i class="fas fa-plus"></i> Add new task
        </a>
    </div>
    <table class="w-100 table table-hover text-center">
        <thead class="table-primary">
            <tr>
                <th class="p-3">ID</th>
                <th class="p-3">Name</th>
                <th class="p-3">Description</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
                <tr class="align-middle">
                    <td class="p-3">{{ $task->id }}</td>
                    <td class="p-3">{{ $task->name }}</td>
                    <td class="p-3">{{ $task->description }}</td>
                    <td>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary"><i
                                    class="fas fa-edit"></i></a>
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <td class="p-3" colspan="4">No tasks found</td>
            @endforelse
        </tbody>
    </table>
</x-dashboard.layout>
