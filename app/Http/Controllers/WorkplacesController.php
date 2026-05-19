<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkplaceRequest;
use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkplacesController extends Controller
{
    use ControllerTrait;

    public function index(Request $request)
    {
        $query = Workplace::query();

        // Apply search using trait method
        $query = $this->applySearch($query, $request, ['name', 'address', 'description', 'phone', 'email']);

        // Paginate results using trait method
        $workplaces = $this->paginateResults($query);

        return view('workplaces.index', compact('workplaces'));
    }

    public function create()
    {
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to create workplaces.');
        }

        return view('workplaces.create');
    }

    function store(WorkplaceRequest $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to create workplaces.');
        }

        try {
            DB::beginTransaction();

            $workplace = Workplace::create([
                'name' => $request->name,
                'address' => $request->address,
                'description' => $request->description,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);

            DB::commit();

            Log::info('Workplace created', ['workplace_id' => $workplace->id, 'user_id' => Auth::id()]);

            return redirect()->route('workplaces.index')
                ->with('success', 'Workplace created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create workplace', ['error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to create workplace. Please try again.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $workplace = Workplace::findOrFail($id);
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to delete workplaces.');
        }

        try {
            DB::beginTransaction();

            $workplace->delete();

            DB::commit();

            Log::info('Workplace deleted', ['workplace_id' => $id, 'user_id' => Auth::id()]);

            return redirect()->route('workplaces.index')
                ->with('success', 'Workplace deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete workplace', ['workplace_id' => $id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to delete workplace. Please try again.');
        }
    }

    public function edit($id)
    {
        $workplace = Workplace::findOrFail($id);
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to edit workplaces.');
        }

        return view('workplaces.edit', compact('workplace'));
    }

    public function update(WorkplaceRequest $request, $id)
    {
        $workplace = Workplace::findOrFail($id);
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to update workplaces.');
        }

        try {
            DB::beginTransaction();

            $workplace->update([
                'name' => $request->name,
                'address' => $request->address,
                'description' => $request->description,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);

            DB::commit();

            Log::info('Workplace updated', ['workplace_id' => $id, 'user_id' => Auth::id()]);

            return redirect()->route('workplaces.index')
                ->with('success', 'Workplace updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update workplace', ['workplace_id' => $id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to update workplace. Please try again.')
                ->withInput();
        }
    }

    /**
     * Restore a soft deleted workplace
     */
    public function restore($id)
    {
        $workplace = Workplace::withTrashed()->findOrFail($id);
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to restore workplaces.');
        }

        try {
            DB::beginTransaction();

            $workplace->restore();

            DB::commit();

            Log::info('Workplace restored', ['workplace_id' => $id, 'user_id' => Auth::id()]);

            return redirect()->route('workplaces.index')
                ->with('success', 'Workplace restored successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to restore workplace', ['workplace_id' => $id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to restore workplace. Please try again.');
        }
    }

    /**
     * Export workplaces to CSV
     */
    public function export(Request $request)
    {
        if (!$this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to export workplaces.');
        }

        try {
            // Apply same filters as index
            $query = Workplace::query();
            $query = $this->applySearch($query, $request, ['name', 'address', 'description', 'phone', 'email']);

            $workplaces = $query->get(['id', 'name', 'address', 'description', 'phone', 'email', 'created_at']);

            // Create CSV content
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="workplaces_' . now()->format('Y-m-d_H-i-s') . '.csv"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $columns = ['ID', 'Name', 'Address', 'Description', 'Phone', 'Email', 'Created At'];

            $callback = function() use($workplaces, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($workplaces as $workplace) {
                    $row['ID'] = $workplace->id;
                    $row['Name'] = $workplace->name;
                    $row['Address'] = $workplace->address;
                    $row['Description'] = $workplace->description;
                    $row['Phone'] = $workplace->phone;
                    $row['Email'] = $workplace->email;
                    $row['Created At'] = $workplace->created_at ? $workplace->created_at->toDateTimeString() : '';

                    fputcsv($file, array_values($row));
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Failed to export workplaces', ['error' => $e->getMessage(), 'user_id' => Auth::id()]);

            return redirect()->back()
                ->with('error', 'Failed to export workplaces. Please try again.');
        }
    }
}
