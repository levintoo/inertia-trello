<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreColumnRequest;
use App\Models\Column;
use Illuminate\Http\Request;

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
    public function update(Request $request, Column $column)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Column $column)
    {
        //
    }
}
