<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkplaceRequest;
use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WorkplacesController extends Controller
{
    use AuthorizesRequests;

    function index(Request $request)
    {
        $this->authorize('viewAny', Workplace::class);

        $query = Workplace::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('address', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }

        $workplaces = $query->latest()->paginate(10)->withQueryString();

        return view('workplaces.index', compact('workplaces'));
    }

    function create()
    {
        $this->authorize('create', Workplace::class);

        return view('workplaces.create');
    }

    function store(WorkplaceRequest $request)
    {
        $this->authorize('create', Workplace::class);

        try {
            Workplace::create([
                'name' => $request->name,
                'address' => $request->address,
                'description' => $request->description,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);

            return redirect()->route('workplaces.index')
                ->with('success', 'Workplace created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create workplace. Please try again.')
                ->withInput();
        }
    }

    function destroy($id)
    {
        $workplace = Workplace::findOrFail($id);
        $this->authorize('delete', $workplace);

        try {
            $workplace->delete();
            return redirect()->route('workplaces.index')
                ->with('success', 'Workplace deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete workplace. Please try again.');
        }
    }

    function edit($id)
    {
        $workplace = Workplace::findOrFail($id);
        $this->authorize('update', $workplace);

        return view('workplaces.edit', compact('workplace'));
    }

    function update(WorkplaceRequest $request, $id)
    {
        $workplace = Workplace::findOrFail($id);
        $this->authorize('update', $workplace);

        try {
            $workplace->update([
                'name' => $request->name,
                'address' => $request->address,
                'description' => $request->description,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);

            return redirect()->route('workplaces.index')
                ->with('success', 'Workplace updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update workplace. Please try again.')
                ->withInput();
        }
    }
}
