<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReorderTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Column;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        $maxPosition = Task::whereBelongsTo($user)->where('column_id', $columnId)->max('position') ?? 0;

        Task::create([
            'user_id' => $user->id,
            'column_id' => $columnId,
            'name' => $validated['name'],
            'position' => $maxPosition + 100,
            'due_date' => $request->has('due_date') ? $validated['due_date'] : null,
        ]);

        return redirect()->back();
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
     * Update the specified resource in storage.
     */
    public function reorder(ReorderTaskRequest $request, Task $task)
    {
        if (! $task->belongsTo(auth()->user())) {
            throw new NotFoundHttpException;
        }

        $validated = $request->validated();

        $task->update([
            'position' => $validated['position'],
            'column_id' => $validated['columnId'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function complete(Task $task)
    {
        if (! $task->belongsTo(auth()->user())) {
            throw new NotFoundHttpException;
        }

        $task->update([
            'completed_at' => now(),
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (! $task->belongsTo(auth()->user())) {
            throw new NotFoundHttpException;
        }

        $task->delete();

        return redirect()->back();
    }
}
