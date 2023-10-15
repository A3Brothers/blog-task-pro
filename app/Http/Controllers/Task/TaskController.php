<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $tasks = auth()->user()->tasks;

            return DataTables::collection($tasks)
                ->addIndexColumn()
                ->setRowId('id')
                ->addColumn('index', function ($row) {
                    static $i = 1;
                    return $i++;
                })
                ->editColumn('title', function ($row) {
                    $url = route('task.show', ['task' => $row->id]);
                    $html = <<<HTML
                    <a href="{$url}" class="text-red-300 hover:text-blue-500">$row->title</a>
                    HTML;
                    return $html;
                })
                ->editColumn('description', '{{words($description, stripHtml: true)}}')
                ->editColumn('status', function ($row) {
                    $color = $row->status === 'completed' ? 'text-green-600' : 'text-red-600';
                    $html = <<<HTML
                        <p class="text-lg uppercase {$color}">$row->status</p>
                    HTML;
                    return $html;
                })
                ->editColumn('due_date', '{{date("d-M-Y", strtotime($due_date))}}')
                ->editColumn('view', function ($row) {
                    $url = route('task.show', ['task' => $row->id]);
                    $imgUrl = asset('assets/image/icons8-view-50.png');
                    $html = <<<HTML
                    <p><a href="{$url}"><img class="w-6" src="$imgUrl" alt="view"></a></p>
                    HTML;
                    return $html;
                })
                ->addColumn('action', function ($row) {
                    $html = view('tasks.partials.action', ['task' => $row])->render();
                    return $html;
                })
                ->rawColumns(['title', 'action', 'status', 'view'])
                ->toJson();
        }
        return view('tasks.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request, Task $task)
    {
        $task = auth()->user()->tasks()->create($request->all());

        return redirectTo($task, 'Task added successfully!', 'task.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('update', $task);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $affectedRow = $task->update($request->all());

        return redirectTo($affectedRow, 'Task updated successfully!', 'task.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('update', $task);

        $affectedRow = $task->delete();

        return redirectTo($affectedRow, 'Task deleted successfully!', 'task.index');
    }
}
