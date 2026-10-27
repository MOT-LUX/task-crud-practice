<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return response()->json([
            'data' => $tasks
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $validated['user_id'] = 1;
        $validated['status'] = 'pending';
        $task = Task::create($validated);
        return response()->json([
            'data' => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'タスクが見つかりません'
            ], 404);
        }
        return response()->json([
            'data' => $task
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'タスクが見つかりません'
            ], 404);
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $task->update($validated);
        return response()->json([
            'data' => $task
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'タスクが見つかりません'
            ], 404);
        }
        $task->delete();


        return response()->noContent();
    }
}
