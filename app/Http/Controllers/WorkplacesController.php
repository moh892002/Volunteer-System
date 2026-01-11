<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkplaceRequest;
use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkplacesController extends Controller
{

    function index(Request $request)
    {
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
        if (!Auth::user()->isAdmin()) {
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
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to delete workplaces.');
        }

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
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to edit workplaces.');
        }

        return view('workplaces.edit', compact('workplace'));
    }

    function update(WorkplaceRequest $request, $id)
    {
        $workplace = Workplace::findOrFail($id);
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to update workplaces.');
        }

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
