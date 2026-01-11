<?php

namespace App\Http\Controllers;

use App\Http\Requests\VolunteerRequest;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VolunteersController extends Controller
{
    use AuthorizesRequests;

    function index(Request $request)
    {
        $this->authorize('viewAny', Volunteer::class);

        $query = Volunteer::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhere('skills', 'like', '%' . $search . '%');
        }

        $volunteers = $query->latest()->paginate(10)->withQueryString();

        return view('volunteers.index', compact('volunteers'));
    }

    function create()
    {
        $this->authorize('create', Volunteer::class);

        return view('volunteers.create');
    }

    function store(VolunteerRequest $request)
    {
        $this->authorize('create', Volunteer::class);

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
        $this->authorize('delete', $volunteer);

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
        $this->authorize('update', $volunteer);

        return view('volunteers.edit', compact('volunteer'));
    }

    function update(VolunteerRequest $request, $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $this->authorize('update', $volunteer);

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
}
