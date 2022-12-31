<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Validator;
use Auth;

class ProjectController extends Controller
{

    public function index()
    {
        $project = Project::all();
        return response()->json([
            'status'=> 200,
            'category' => $project,
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

            $project                = new Project();
            $project->name          = $request->name;
            $project->des           = $request->des;
            $project->tech          = $request->tech;
            $project->start_date    = $request->start_date;
            $project->delivery_date = $request->delivery_date;
            $project->user_id       = auth::user()->id;
            $project->save();

            return response()->json([
                'status' =>  200,
                'message'=> 'project Created Successfully!',
            ]);
        }
    }


    public function show($id)
    {
        $project = Project::find($id);
        if($project)
        {
            return response()->json([
                'status' => 200,
                'project'=> $project,
            ]);
        }
        else
        {
            return response()->josn([
                'status' =>  404,
                'message'=> 'No project found!',
            ]);
        }
    }


    public function edit($id)
    {
        $project = Project::find($id);
        if($project)
        {
            return response()->json([
                'status'=>200,
                'project'=>$project,
            ]);
        }
        else
        {
            return response()->josn([
                'status'=>404,
                'message'=>'No project found!',
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
          
           
            $project                = Project::find($id);
            $project->name          = $request->name;
            $project->des           = $request->des;
            $project->tech          = $request->tech;
            $project->start_date    = $request->start_date;
            $project->delivery_date = $request->delivery_date;
            $project->user_id       = auth::user()->id;
            $project->save();

            return response()->json([
                'status'=>200,
                'message'=> 'project Created Successfully!',
            ]);
        }
    }


    public function destroy($id)
    {
        $project = Project::find($id);
        if($project)
        {
            $project->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'project Deleted Successfully!',
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=> 'project not found!',
            ]);
        }
    }
}
