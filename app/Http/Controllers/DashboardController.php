<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\Task;
use App\Models\Workplace;
use App\Models\Assignment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get basic statistics
        $stats = [
            'total_volunteers' => Volunteer::count(),
            'total_tasks' => Task::count(),
            'total_workplaces' => Workplace::count(),
            'total_assignments' => Assignment::count(),
            'recent_volunteers' => Volunteer::latest()->take(5)->get(),
            'recent_tasks' => Task::latest()->take(5)->get(),
            'recent_workplaces' => Workplace::latest()->take(5)->get(),
            'recent_assignments' => Assignment::with(['volunteer', 'task', 'workplace'])
                ->latest()
                ->take(5)
                ->get(),
        ];

        // Get assignment statistics by volunteer
        $volunteerStats = Volunteer::withCount('assignments')
            ->orderBy('assignments_count', 'desc')
            ->take(10)
            ->get();

        // Get assignment statistics by workplace
        $workplaceStats = Workplace::withCount('assignments')
            ->orderBy('assignments_count', 'desc')
            ->take(10)
            ->get();

        // Get assignment statistics by task
        $taskStats = Task::withCount('assignments')
            ->orderBy('assignments_count', 'desc')
            ->take(10)
            ->get();

        // Get recent activity (last 10 assignments)
        $recentActivity = Assignment::with(['volunteer', 'task', 'workplace'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.index', compact(
            'stats',
            'volunteerStats',
            'workplaceStats',
            'taskStats',
            'recentActivity'
        ));
    }

    public function home()
    {
        $q = request('q');

        $assignments = Assignment::with(['volunteer', 'task', 'workplace']);

        if ($q) {
            $assignments = $assignments->where(function ($query) use ($q) {
                $query->whereHas('volunteer', function ($sub) use ($q) {
                    $sub->whereRaw('LOWER(name) LIKE LOWER(?)', ['%' . $q . '%']);
                })
                    ->orWhereHas('task', function ($sub) use ($q) {
                        $sub->whereRaw('LOWER(name) LIKE LOWER(?)', ['%' . $q . '%']);
                    })
                    ->orWhereHas('workplace', function ($sub) use ($q) {
                        $sub->whereRaw('LOWER(name) LIKE LOWER(?)', ['%' . $q . '%']);
                    })
                    ->orWhereRaw('LOWER(status) LIKE LOWER(?)', ['%' . $q . '%']);
            });
        }

        $assignments = $assignments->paginate(10);

        return view('home', compact('assignments'));
    }
}
