<?php

namespace App\Http\Controllers;

use App\Exports\TasksExport;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
    public function store(Request $request)
    {
        // Validate request data including image file
        $validator = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'taskname' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'task_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // dd($validator);
        // Handle file upload
        $taskImagePath = null;
        if ($request->hasFile('task_image')) {
            $taskImagePath = $request->file('task_image')->store('task_images', 'public'); // Store image in 'public/task_images' directory
        }

        // Create task with image path
        $task = Task::create([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'taskname' => $request->taskname,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'image_path' => $taskImagePath, // Store image path in the database
        ]);

        // Redirect with success message
        return redirect()->route('dashboard')->with('success', 'Task added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json($task);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validator = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'taskname' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'task_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // dd($validator);
        $taskImagePath = $task->image_path;
        if ($request->hasFile('task_image')) {
            if ($taskImagePath && Storage::disk('public')->exists($taskImagePath)) {
                Storage::disk('public')->delete($taskImagePath);
            }

            $taskImagePath = $request->file('task_image')->store('task_images', 'public');
        }

        $task->update([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'taskname' => $request->taskname,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'image_path' => $taskImagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Task updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->task_ids;
        // dd($ids);
        if ($ids) {
            $idsArray = explode(',', $ids);
            $tasks = Task::whereIn('id', $idsArray)->get();

            foreach ($tasks as $task) {
                if ($task->image_path && Storage::disk('public')->exists($task->image_path)) {
                    Storage::disk('public')->delete($task->image_path);
                }
            }
            Task::whereIn('id', $idsArray)->delete();
            return redirect()->route('dashboard')->with('success', 'Selected items deleted successfully.');
        }

        return response()->json(['message' => 'No tasks selected'], 400);
    }

    public function search(Request $request)
    {

        $tasks = Task::where('taskname', 'LIKE', '%' . $request->Value . '%')
            ->orWhere('description', 'LIKE', '%' . $request->Value . '%')
            ->orWhere('start_date', 'LIKE', '%' . $request->Value . '%')
            ->orWhere('end_date', 'LIKE', '%' . $request->Value . '%')
            ->orWhereHas('user', function ($query) use ($request) {
                $query->where('fullname', 'LIKE', '%' . $request->Value . '%');
            })
            ->orWhereHas('category', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->Value . '%');
            })
            ->get();

        return view('tasks.search', compact('tasks'));
    }

    public function filter(Request $request)
    {
        $categoryId = $request->category_id;

        if ($categoryId) {
            $tasks = Task::where('category_id', $categoryId)->get();
        } else {
            $tasks = Task::all(); // Fetch all tasks if no category is selected
        }

        return view('tasks.search', compact('tasks'));
    }

    public function export(Request $request)
    {
        $query = Task::with('category');

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search') && $request->search) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('taskname', 'LIKE', $searchTerm)
                    ->orWhere('description', 'LIKE', $searchTerm)
                    ->orWhere('start_date', 'LIKE', $searchTerm)
                    ->orWhere('end_date', 'LIKE', $searchTerm)
                    ->orWhereHas('user', function ($query) use ($searchTerm) {
                        $query->where('fullname', 'LIKE', $searchTerm);
                    })
                    ->orWhereHas('category', function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', $searchTerm);
                    });
            });
        }

        $tasks = $query->get();

        return Excel::download(new TasksExport($tasks), 'tasks.xlsx');
    }
}
