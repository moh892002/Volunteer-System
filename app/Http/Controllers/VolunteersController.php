<?php

namespace App\Http\Controllers;

use App\Http\Requests\VolunteerRequest;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VolunteersController extends Controller
{
    use ControllerTrait;

    function index(Request $request)
    {
        $query = Volunteer::query();

        // Apply search using trait method
        $query = $this->applySearch($query, $request, ['name', 'email', 'phone', 'skills']);

        // Paginate results using trait method
        $volunteers = $this->paginateResults($query);

        return view('volunteers.index', compact('volunteers'));
    }

    function create()
    {
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to create volunteers.');
        }

        return view('volunteers.create');
    }

    function store(VolunteerRequest $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to create volunteers.');
        }

        try {
            DB::beginTransaction();

            $volunteer = Volunteer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'skills' => $request->skills,
            ]);

            DB::commit();

            Log::info('Volunteer created', ['volunteer_id' => $volunteer->id, 'user_id' => Auth::id()]);

            return redirect()->route('volunteers.index')
                ->with('success', 'Volunteer created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create volunteer', ['error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to create volunteer. Please try again.')
                ->withInput();
        }
    }

    function destroy($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to delete volunteers.');
        }

        try {
            DB::beginTransaction();

            $volunteer->delete();

            DB::commit();

            Log::info('Volunteer deleted', ['volunteer_id' => $id, 'user_id' => Auth::id()]);

            return redirect()->route('volunteers.index')
                ->with('success', 'Volunteer deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete volunteer', ['volunteer_id' => $id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to delete volunteer. Please try again.');
        }
    }

    function edit($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to edit volunteers.');
        }

        return view('volunteers.edit', compact('volunteer'));
    }

    function update(VolunteerRequest $request, $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to update volunteers.');
        }

        try {
            DB::beginTransaction();

            $volunteer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'skills' => $request->skills,
            ]);

            DB::commit();

            Log::info('Volunteer updated', ['volunteer_id' => $id, 'user_id' => Auth::id()]);

            return redirect()->route('volunteers.index')
                ->with('success', 'Volunteer updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update volunteer', ['volunteer_id' => $id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to update volunteer. Please try again.')
                ->withInput();
        }
    }

    /**
     * Restore a soft deleted volunteer
     */
    function restore($id)
    {
        $volunteer = Volunteer::withTrashed()->findOrFail($id);
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to restore volunteers.');
        }

        try {
            DB::beginTransaction();

            $volunteer->restore();

            DB::commit();

            Log::info('Volunteer restored', ['volunteer_id' => $id, 'user_id' => Auth::id()]);

            return redirect()->route('volunteers.index')
                ->with('success', 'Volunteer restored successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to restore volunteer', ['volunteer_id' => $id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to restore volunteer. Please try again.');
        }
    }

    /**
     * Export volunteers to CSV
     */
    public function export(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to export volunteers.');
        }

        try {
            // Apply same filters as index
            $query = Volunteer::query();
            $query = $this->applySearch($query, $request, ['name', 'email', 'phone', 'skills']);

            $volunteers = $query->get(['id', 'name', 'email', 'phone', 'skills', 'created_at']);

            // Create CSV content
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="volunteers_' . now()->format('Y-m-d_H-i-s') . '.csv"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $columns = ['ID', 'Name', 'Email', 'Phone', 'Skills', 'Created At'];

            $callback = function() use($volunteers, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($volunteers as $volunteer) {
                    $row['ID'] = $volunteer->id;
                    $row['Name'] = $volunteer->name;
                    $row['Email'] = $volunteer->email;
                    $row['Phone'] = $volunteer->phone;
                    $row['Skills'] = $volunteer->skills;
                    $row['Created At'] = $volunteer->created_at ? $volunteer->created_at->toDateTimeString() : '';

                    fputcsv($file, array_values($row));
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Failed to export volunteers', ['error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to export volunteers. Please try again.');
        }
    }
}
