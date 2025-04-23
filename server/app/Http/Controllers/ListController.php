<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lists = TaskList::where('user_id', auth()->id())
            ->with('tasks')
            ->get();

        return Inertia::render('Lists/Index', [
            'lists' => $lists,
            'flash' => [
                'success' => session('success'),
                'error' => session('error')
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|url', // Changed to URL validation
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
        ]);

        TaskList::create([
            ...$validated,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('lists.index')->with('success', 'List created successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskList $list)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|url', // Changed to URL validation
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
        ]);

        $list->update($validated);

        return redirect()->route('lists.index')->with('success', 'List updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskList $list)
    {
        $list->delete();
        return redirect()->route('lists.index')->with('success', 'List deleted successfully!');
    }

    /**
     * API: Get all lists
     */
    public function apiIndex()
    {
        $lists = TaskList::with('tasks')->get();

        return response()->json([
            'success' => true,
            'data' => $lists
        ]);
    }

    /**
     * API: Get a specific list
     */
    public function apiShow($id)
    {
        $list = TaskList::with('tasks')->find($id);

        if (!$list) {
            return response()->json([
                'success' => false,
                'message' => 'List not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $list
        ]);
    }

    /**
     * API: Create a new list
     */
    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|url', // Changed to URL validation
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
        ]);

        $list = TaskList::create($validated);

        return response()->json([
            'success' => true,
            'data' => $list
        ], 201);
    }

    /**
     * API: Update a list
     */
    public function apiUpdate(Request $request, $id)
    {
        $list = TaskList::find($id);

        if (!$list) {
            return response()->json([
                'success' => false,
                'message' => 'List not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|url', // Changed to URL validation
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'quantity' => 'sometimes|integer|min:0',
        ]);

        $list->update($validated);

        return response()->json([
            'success' => true,
            'data' => $list
        ]);
    }

    /**
     * API: Delete a list
     */
    public function apiDestroy($id)
    {
        $list = TaskList::find($id);

        if (!$list) {
            return response()->json([
                'success' => false,
                'message' => 'List not found'
            ], 404);
        }

        $list->delete();

        return response()->json([
            'success' => true,
            'message' => 'List deleted successfully'
        ]);
    }
}
