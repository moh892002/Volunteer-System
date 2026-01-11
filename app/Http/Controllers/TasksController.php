<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    function index(Request $request)
    {

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
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to create tasks.');
        }

        return view('tasks.create');
    }

    function store(TaskRequest $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to create tasks.');
        }

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
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to delete tasks.');
        }

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
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to edit tasks.');
        }

        return view('tasks.edit', compact('task'));
    }

    function update(TaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to update tasks.');
        }

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
