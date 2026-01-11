<x-dashboard.layout>
    <x-slot:title>Assignments</x-slot:title>
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h1>All Assignments</h1>
        <a class="btn btn-secondary p-2" href="{{ route('assignment.create') }}">
            <i class="fas fa-plus"></i> Add new assignment
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search and Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('assignment.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search"
                        value="{{ request('search') }}" placeholder="Search volunteers, tasks, or workplaces">
                </div>
                <div class="col-md-2">
                    <label for="volunteer_id" class="form-label">Volunteer</label>
                    <select class="form-select" id="volunteer_id" name="volunteer_id">
                        <option value="">All Volunteers</option>
                        @foreach ($volunteers as $volunteer)
                            <option value="{{ $volunteer->id }}"
                                {{ request('volunteer_id') == $volunteer->id ? 'selected' : '' }}>
                                {{ $volunteer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="workplace_id" class="form-label">Workplace</label>
                    <select class="form-select" id="workplace_id" name="workplace_id">
                        <option value="">All Workplaces</option>
                        @foreach ($workplaces as $workplace)
                            <option value="{{ $workplace->id }}"
                                {{ request('workplace_id') == $workplace->id ? 'selected' : '' }}>
                                {{ $workplace->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="task_id" class="form-label">Task</label>
                    <select class="form-select" id="task_id" name="task_id">
                        <option value="">All Tasks</option>
                        @foreach ($tasks as $task)
                            <option value="{{ $task->id }}"
                                {{ request('task_id') == $task->id ? 'selected' : '' }}>
                                {{ $task->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Statuses</option>
                        @foreach (\App\Models\Assignment::getStatusOptions() as $value => $label)
                            <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <a href="{{ route('assignment.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <table class="table text-center table-hover align-middle">
        <thead class="table-primary">
            <tr>
                <th>Volunteer Name</th>
                <th>Volunteer Phone</th>
                <th>WorkPlace</th>
                <th>Task Name</th>
                <th>Volunteer Skills</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($assignments as $assignment)
                <tr class="align-middle">
                    <td>{{ $assignment->volunteer->name }}</td>
                    <td>{{ $assignment->volunteer->phone }}</td>
                    <td>{{ $assignment->workplace->name }}</td>
                    <td>{{ $assignment->task->name }}</td>
                    <td>{{ $assignment->volunteer->skills }}</td>
                    <td>
                        <form action="{{ route('assignment.update-status', $assignment->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()"
                                style="min-width: 120px;">
                                @foreach (\App\Models\Assignment::getStatusOptions() as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ $assignment->status === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('assignment.destroy', $assignment->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('assignment.edit', $assignment->id) }}" class="btn btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this assignment?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No assignments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $assignments->links() }}
    </div>
</x-dashboard.layout>
