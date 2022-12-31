<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Validator;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::all();
        return response()->json([
            'status'=> 200,
            'category' => $tasks,
        ]); 
    }

    public function create()
    {
       
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
 
        ]);


        if($validator->fails())
        {
            return response()->json([
                'status'=> 400,
                'errors'=> $validator->messages(),
            ]);
        }
        else

        {
            $task                = new Task();
            $task->name          = $request->name;
            $task->des           = $request->des;
            $task->status        = $request->status;
            $task->start         = $request->start;
            $task->end           = $request->end;
            $task->project_id    = $request->project_id;
            $task->save();

            return response()->json([
                'status' =>  200,
                'message'=> 'Task Created Successfully!',
            ]);
        }
    }


    public function show($id)
    {
        $task = Task::find($id);
        if($task)
        {
            return response()->json([
                'status' => 200,
                'task'=> $task,
            ]);
        }
        else
        {
            return response()->josn([
                'status' =>  404,
                'message'=> 'No task found!',
            ]);
        }
    }


    public function edit($id)
    {
         $task = Task::find($id);
        if($task)
        {
            return response()->json([
                'status'=>200,
                'task'=>$task,
            ]);
        }
        else
        {
            return response()->josn([
                'status'=>404,
                'message'=>'No task found!',
            ]);
        }
    }


    public function update(Request $request, $id)
    {
       $validator = Validator::make($request->all(), [
            'name'        => 'required',
 
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else
        {
          
            $task                = Task::find($id);
            $task->name          = $request->name;
            $task->des           = $request->des;
            $task->status        = $request->status;
            $task->start         = $request->start;
            $task->end           = $request->end;
            $task->project_id    = $request->project_id;
            $task->save();

            return response()->json([
                'status'=>200,
                'message'=> 'task Created Successfully!',
            ]);
        }
    }


    public function destroy($id)
    {
        $task = Task::find($id);
        if($task)
        {
            $task->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'task Deleted Successfully!',
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=> 'task not found!',
            ]);
        }
    }
}