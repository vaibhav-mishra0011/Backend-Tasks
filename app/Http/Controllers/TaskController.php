<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;


class TaskController extends Controller
{
    public function index(Request $request)
    {
        Log::debug("Going to load tasks");
        $roleData = Auth::user()->role_id;


        // GET TASK from DB
        try {
            if ($roleData == 1) {
                $tasks = Task::orderBy($request->sortBy, $request->desc ? 'desc' : 'asc')->paginate($request->perPage ? $request->perPage : 10);
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

            $task = Task::create([
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'completed' => $request->completed

            ]);

            Log::debug("Task crated successfully");
            return response()->json(['success' => true, 'data' => $task]);

            //return redirect()->route('tasks.index');
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }

    }
    public function updateTask(Request $request, $id)
    {

        try {
            $task = Task::findOrFail($id);
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
    }
}

