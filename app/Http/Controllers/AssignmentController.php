<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Volunteer;
use App\Models\Workplace;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AssignmentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssignmentController extends Controller
{
    use ControllerTrait;

    public function index(Request $request)
    {
        $query = Assignment::with(['volunteer', 'workplace', 'task']);

        // Apply search using trait method for basic search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('volunteer', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
                ->orWhereHas('workplace', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('task', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        }

        // Apply filters
        if ($request->has('volunteer_id') && !empty($request->volunteer_id)) {
            $query->where('volunteer_id', $request->volunteer_id);
        }

        if ($request->has('workplace_id') && !empty($request->workplace_id)) {
            $query->where('workplace_id', $request->workplace_id);
        }

        if ($request->has('task_id') && !empty($request->task_id)) {
            $query->where('task_id', $request->task_id);
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Apply ordering and pagination using trait method
        $query = $query->latest();
        $assignments = $this->paginateResults($query);

        // For filter dropdowns
        $volunteers = Volunteer::all();
        $workplaces = Workplace::all();
        $tasks = Task::all();

        return view('assignments.index', compact('assignments', 'volunteers', 'workplaces', 'tasks'));
    }


    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to create assignments.');
        }

        $volunteers = Volunteer::all();
        $workplaces = Workplace::all();
        $tasks = Task::all();

        return view('assignments.create', compact('volunteers', 'workplaces', 'tasks'));
    }


    public function store(AssignmentRequest $request)
    {
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to create assignments.');
        }

        try {
            DB::beginTransaction();

            $assignment = Assignment::create($request->validated());

            DB::commit();

            Log::info('Assignment created', ['assignment_id' => $assignment->id, 'user_id' => Auth::id()]);

            return redirect()->route('assignment.index')
                ->with('success', 'Assignment created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create assignment', ['error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to create assignment. Please try again.')
                ->withInput();
        }
    }

    public function edit($id)
    {
        $assignment = Assignment::findOrFail($id);
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to edit assignments.');
        }

        $volunteers = Volunteer::all();
        $workplaces = Workplace::all();
        $tasks = Task::all();

        return view('assignments.edit', compact('assignment', 'volunteers', 'workplaces', 'tasks'));
    }


    public function update(AssignmentRequest $request, $id)
    {
        $assignment = Assignment::findOrFail($id);
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to update assignments.');
        }

        try {
            DB::beginTransaction();

            $assignment->update($request->validated());

            DB::commit();

            Log::info('Assignment updated', ['assignment_id' => $id, 'user_id' => Auth::id()]);

            return redirect()->route('assignment.index')
                ->with('success', 'Assignment updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update assignment', ['assignment_id' => $id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to update assignment. Please try again.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to delete assignments.');
        }

        try {
            DB::beginTransaction();

            $assignment->delete();

            DB::commit();

            Log::info('Assignment deleted', ['assignment_id' => $id, 'user_id' => Auth::id()]);

            return redirect()->route('assignment.index')
                ->with('success', 'Assignment deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete assignment', ['assignment_id' => $id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to delete assignment. Please try again.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to update assignment status.');
        }

        $request->validate([
            'status' => 'required|in:pending,active,completed'
        ]);

        try {
            DB::beginTransaction();

            $assignment->update(['status' => $request->status]);

            DB::commit();

            $statusText = ucfirst($request->status);
            Log::info('Assignment status updated', ['assignment_id' => $id, 'status' => $request->status, 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('success', "Assignment status updated to {$statusText} successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update assignment status', ['assignment_id' => $id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to update assignment status. Please try again.');
        }
    }

    /**
     * Restore a soft deleted assignment
     */
    public function restore($id)
    {
        $assignment = Assignment::withTrashed()->findOrFail($id);
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to restore assignments.');
        }

        try {
            DB::beginTransaction();

            $assignment->restore();

            DB::commit();

            Log::info('Assignment restored', ['assignment_id' => $id, 'user_id' => Auth::id()]);

            return redirect()->route('assignment.index')
                ->with('success', 'Assignment restored successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to restore assignment', ['assignment_id' => $id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to restore assignment. Please try again.');
        }
    }

    /**
     * Export assignments to CSV
     */
    public function export(Request $request)
    {
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to export assignments.');
        }

        try {
            // Apply same filters as index
            $query = Assignment::with(['volunteer', 'workplace', 'task']);

            // Apply search
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->whereHas('volunteer', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('workplace', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('task', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            }

            // Apply filters
            if ($request->has('volunteer_id') && !empty($request->volunteer_id)) {
                $query->where('volunteer_id', $request->volunteer_id);
            }

            if ($request->has('workplace_id') && !empty($request->workplace_id)) {
                $query->where('workplace_id', $request->workplace_id);
            }

            if ($request->has('task_id') && !empty($request->task_id)) {
                $query->where('task_id', $request->task_id);
            }

            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }

            $assignments = $query->get([
                'id',
                'status',
                'created_at'
            ]);

            // Create CSV content
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="assignments_' . now()->format('Y-m-d_H-i-s') . '.csv"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $columns = ['ID', 'Volunteer Name', 'Workplace Name', 'Task Name', 'Status', 'Created At'];

            $callback = function() use($assignments, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($assignments as $assignment) {
                    $row['ID'] = $assignment->id;
                    $row['Volunteer Name'] = $assignment->volunteer->name ?? 'N/A';
                    $row['Workplace Name'] = $assignment->workplace->name ?? 'N/A';
                    $row['Task Name'] = $assignment->task->name ?? 'N/A';
                    $row['Status'] = ucfirst($assignment->status);
                    $row['Created At'] = $assignment->created_at ? $assignment->created_at->toDateTimeString() : '';

                    fputcsv($file, array_values($row));
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Failed to export assignments', ['error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to export assignments. Please try again.');
        }
    }
}
