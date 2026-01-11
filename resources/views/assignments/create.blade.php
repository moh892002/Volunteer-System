<x-dashboard.layout>
    <x-slot:title>Create Assignment</x-slot:title>
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h1>Create New Assignment</h1>
        <a class="btn btn-secondary p-2" href="{{ route('assignment.index') }}">
            <i class="fas fa-arrow-left"></i> all assignments
        </a>
    </div>

    <form action="{{ route('assignment.store') }}" method="POST" class="row">
        @csrf
        <div class="mb-3">
            <label for="volunteer_id" class="form-label">Volunteer</label>
            <select name="volunteer_id" id="volunteer_id" class="form-select">
                @foreach ($volunteers as $volunteer)
                    <option value="{{ $volunteer->id }}">{{ $volunteer->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="workplace_id" class="form-label">Workplace</label>
            <select name="workplace_id" id="workplace_id" class="form-select">
                @foreach ($workplaces as $workplace)
                    <option value="{{ $workplace->id }}">{{ $workplace->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="task_id" class="form-label">Task</label>
            <select name="task_id" id="task_id" class="form-select">
                @foreach ($tasks as $task)
                    <option value="{{ $task->id }}">{{ $task->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary w-100">Create</button>
        </div>
    </form>
</x-dashboard.layout>
