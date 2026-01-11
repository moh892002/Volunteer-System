<x-dashboard.layout>
    <x-slot:title>Edit Task</x-slot:title>

    <div class="w-75 mx-auto mt-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h1 class="">Edit Task</h1>

            <a class="btn btn-secondary p-2 mx-start" href="{{ route('tasks.index') }}">
                <i class="fas fa-arrow-left"></i> all tasks</a>
        </div>

        <form class="row" action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')

            <x-input type='text' name='name' label='Name' value='{{ $task->name }}' />
            <x-input type='text' name='description' label='Description' value='{{ $task->description }}' />
            <div class="mb-1">
                <button type="submit" class="btn btn-success w-100">Update</button>
            </div>
        </form>

    </div>

</x-dashboard.layout>
