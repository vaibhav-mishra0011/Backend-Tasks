<?php

namespace App\Http\Controllers;

use App\Exports\TaskListExport;
use App\Imports\TaskListImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Task;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;


class TaskController extends Controller
{

    public function index(Request $request)
    {
        Log::debug("Going to load tasks");
        // GET TASK from DB
        try {
            if (Auth::user()->hasRole('admin')) {
                $tasks = Task::orderBy($request->sortBy, $request->desc == 'true' ? 'desc' : 'asc')->paginate($request->perPage ? $request->perPage : 10);
                return response()->json(['success' => true, 'data' => $tasks]);
            } else {
                $tasks = Task::where('user_id', Auth::user()->id)->orderBy($request->sortBy, $request->desc ? 'desc' : 'asc')->paginate($request->perPage ? $request->perPage : 10);
                return response()->json(['success' => true, 'data' => $tasks]);
            }


        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function getUserTasks($id)
    {
        try {
            $tasks = Task::where("user_id", $id)->get();
            return response()->json(['success' => true, 'data' => $tasks]);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
    public function create()
    {
        return view('tasks.create');
    }

    public function destroy($id)
    {

        try {
            $task = Task::destroy($id);
            return response()->json(['success' => true, 'data' => $task]);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }

    }



    public function store(Request $request)
    {

        try {
            Log::debug('Got request to save task with ==> ');
            Log::debug($request->all());

            $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
                'user_id' => 'required'
            ]);
            if (!Auth::user()->hasRole('admin')) {
                $task = Task::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'user_id' => Auth::user()->id,
                    'completed' => $request->completed
                ]);
                Log::debug("Task crated successfully");
                return response()->json(['success' => true, 'message' => 'task created successfully', 'data' => $task]);
            } else {
                return response()->json(['success' => false, 'message' => 'You are not authorized to create task'], 500);
            }
            //return redirect()->route('tasks.index');
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }

    }
    public function updateTask(Request $request, $id)
    {

        if (!Auth::user()->hasRole('admin')) {
            try {
                $task = Task::where(['user_id' => Auth::user()->id, 'id' => $id])->first();
                $task->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'completed' => $request->completed,
                ]);
                Log::debug('successfully updated');
                return response()->json(['success' => true, 'data' => $task]);
            } catch (\Exception $e) {
                Log::error($e);
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'you are not authorized to edit the tasks'], 500);
        }
    }
    public function export()
    {
        return Excel::download(new TaskListExport, 'task_list.xlsx');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        $file = $request->file('file')->store('files');
        Excel::import(new TaskListImport, $file);
        Log::debug(request()->all());

        return response()->json(['message' => 'File uploaded and processed successfully']);
    }
}

