<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Illuminate\Http\Request;

class KanbanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $columns = Column::query()
            ->orderBy('position', 'ASC')
            ->whereBelongsTo(auth()->user())
            ->with('tasks')
            ->get();

        return inertia('Kanban', compact('columns'));
    }
}
