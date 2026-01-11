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

class AssignmentController extends Controller
{

    public function index(Request $request)
    {
        $query = Assignment::with(['volunteer', 'workplace', 'task'])
            ->latest();

        // Search functionality
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

        // Filter by volunteer
        if ($request->has('volunteer_id') && !empty($request->volunteer_id)) {
            $query->where('volunteer_id', $request->volunteer_id);
        }

        // Filter by workplace
        if ($request->has('workplace_id') && !empty($request->workplace_id)) {
            $query->where('workplace_id', $request->workplace_id);
        }

        // Filter by task
        if ($request->has('task_id') && !empty($request->task_id)) {
            $query->where('task_id', $request->task_id);
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $assignments = $query->paginate(10)->withQueryString();

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
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to create assignments.');
        }

        try {
            Assignment::create($request->validated());
            return redirect()->route('assignment.index')
                ->with('success', 'Assignment created successfully!');
        } catch (\Exception $e) {
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
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to update assignments.');
        }

        try {
            $assignment->update($request->validated());
            return redirect()->route('assignment.index')
                ->with('success', 'Assignment updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update assignment. Please try again.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to delete assignments.');
        }

        try {
            $assignment->delete();
            return redirect()->route('assignment.index')
                ->with('success', 'Assignment deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete assignment. Please try again.');
        }
    }

    /**
     * Update assignment status
     */
    public function updateStatus(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to update assignment status.');
        }

        $request->validate([
            'status' => 'required|in:pending,active,completed'
        ]);

        try {
            $assignment->update(['status' => $request->status]);

            $statusText = ucfirst($request->status);
            return redirect()->back()
                ->with('success', "Assignment status updated to {$statusText} successfully!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update assignment status. Please try again.');
        }
    }
}
