<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Column;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();

        $user = auth()->user();

        $columnId = Column::query()->whereBelongsTo($user)->findOrFail($validated['column_id'])->id;

        $maxPosition = Task::whereBelongsTo($user)->max('position') ?? 0;

        Task::create([
            'user_id' => $user->id,
            'column_id' => $columnId,
            'name' => $validated['name'],
            'position' => $maxPosition + 1000,
            'due_date' => $request->has('due_date') ? $validated['due_date'] : null,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
