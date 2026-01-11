<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TasksController extends Controller
{
    use AuthorizesRequests;

    function index(Request $request)
    {
        $this->authorize('viewAny', Task::class);

        $query = Task::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

        $tasks = $query->latest()->paginate(10)->withQueryString();

        return view('tasks.index', compact('tasks'));
    }

    function create()
    {
        $this->authorize('create', Task::class);

        return view('tasks.create');
    }

    function store(TaskRequest $request)
    {
        $this->authorize('create', Task::class);

        try {
            Task::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->route('tasks.index')
                ->with('success', 'Task created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create task. Please try again.')
                ->withInput();
        }
    }

    function destroy($id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('delete', $task);

        try {
            $task->delete();
            return redirect()->route('tasks.index')
                ->with('success', 'Task deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete task. Please try again.');
        }
    }

    function edit($id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

    function update(TaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('update', $task);

        try {
            $task->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->route('tasks.index')
                ->with('success', 'Task updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update task. Please try again.')
                ->withInput();
        }
    }
}
