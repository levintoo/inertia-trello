<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReorderColumnRequest;
use App\Http\Requests\StoreColumnRequest;
use App\Http\Requests\UpdateColumnRequest;
use App\Models\Column;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ColumnController extends Controller
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
    public function store(StoreColumnRequest $request)
    {
        $validated = $request->validated();

        $maxPosition = Column::where('user_id', auth()->id())->max('position') ?? 0;

        Column::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'position' => $maxPosition + 1000,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Column $column)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Column $column)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColumnRequest $request, Column $column)
    {
        if (! $column->belongsTo(auth()->user())) {
            throw new NotFoundHttpException;
        }

        $column->update($request->validated());
    }

    /**
     * Update the specified resource in storage.
     */
    public function reorder(ReorderColumnRequest $request, Column $column)
    {
        if (! $column->belongsTo(auth()->user())) {
            throw new NotFoundHttpException;
        }

        $validated = $request->validated();

        $column->update([
            'position' => $validated['position'],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Column $column)
    {
        if (! $column->belongsTo(auth()->user())) {
            throw new NotFoundHttpException;
        }

        DB::transaction(function () use ($column) {
            $column->tasks()->chunk(100, function ($tasks) {
                DB::table('tasks')->whereIn('id', $tasks->pluck('id'))->delete();
            });

            $column->delete();
        });

        return redirect()->back();
    }
}
