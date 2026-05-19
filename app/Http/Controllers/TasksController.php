<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TasksController extends Controller
{
    use ControllerTrait;
    public function index(Request $request)
    {
        $query = Task::query();

        // Apply search using trait method
        $query = $this->applySearch($query, $request, ['name', 'description']);

        // Paginate results using trait method
        $tasks = $this->paginateResults($query);

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        if (!$this->isAdmin()) {
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
            DB::beginTransaction();

            $task = Task::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            DB::commit();

            Log::info('Task created', ['task_id' => $task->id, 'user_id' => Auth::id()]);

            return redirect()->route('tasks.index')
                ->with('success', 'Task created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create task', ['error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to create task. Please try again.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to delete tasks.');
        }

        try {
            DB::beginTransaction();

            $task->delete();

            DB::commit();

            Log::info('Task deleted', ['task_id' => $id, 'user_id' => Auth::id()]);

            return redirect()->route('tasks.index')
                ->with('success', 'Task deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete task', ['task_id' => $id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to delete task. Please try again.');
        }
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to edit tasks.');
        }

        return view('tasks.edit', compact('task'));
    }

    public function update(TaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to update tasks.');
        }

        try {
            DB::beginTransaction();

            $task->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            DB::commit();

            Log::info('Task updated', ['task_id' => $id, 'user_id' => Auth::id()]);

            return redirect()->route('tasks.index')
                ->with('success', 'Task updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update task', ['task_id' => $id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to update task. Please try again.')
                ->withInput();
        }
    }

    /**
     * Restore a soft deleted task
     */
    public function restore($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to restore tasks.');
        }

        try {
            DB::beginTransaction();

            $task->restore();

            DB::commit();

            Log::info('Task restored', ['task_id' => $id, 'user_id' => Auth::id()]);

            return redirect()->route('tasks.index')
                ->with('success', 'Task restored successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to restore task', ['task_id' => $id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to restore task. Please try again.');
        }
    }

    /**
     * Export tasks to CSV
     */
    public function export(Request $request)
    {
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to export tasks.');
        }

        try {
            // Apply same filters as index
            $query = Task::query();
            $query = $this->applySearch($query, $request, ['name', 'description']);

            $tasks = $query->get(['id', 'name', 'description', 'created_at']);

            // Create CSV content
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="tasks_' . now()->format('Y-m-d_H-i-s') . '.csv"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $columns = ['ID', 'Name', 'Description', 'Created At'];

            $callback = function() use($tasks, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($tasks as $task) {
                    $row['ID'] = $task->id;
                    $row['Name'] = $task->name;
                    $row['Description'] = $task->description;
                    $row['Created At'] = $task->created_at ? $task->created_at->toDateTimeString() : '';

                    fputcsv($file, array_values($row));
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Failed to export tasks', ['error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to export tasks. Please try again.');
        }
    }
}
