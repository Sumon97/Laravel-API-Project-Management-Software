<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectRequirement;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Validator;
use Auth;

class ProjectRequirementController extends Controller
{
    
     public function index()
    {
        $prs = ProjectRequirement::all();
        return response()->json([
            'status'=> 200,
            'category' => $prs,
        ]); 
    }

    public function create()
    {
       
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            
 
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
            if($request->hasFile('image')){
                //get filename with the extension
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                // GET just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //get just ext
                $extension = $request->file('image')->getClientOriginalExtension();
                //filename to store
                $fileProjecName = $filename.'_'.time().'.'.$extension;
                //upload image
                $path = $request->file('image')->storeAs('public/project', $fileProjecName);

            } else {
                $fileProjecName = 'no.png';
            }

            $prs                = new ProjectRequirement();
            $prs->des           = $request->des;
            $prs->image         = $fileProjecName;
            $prs->project_id    = $request->project_id;
            $prs->save();

            return response()->json([
                'status' =>  200,
                'message'=> 'project requirement Created Successfully!',
            ]);
        }
    }


    public function show($id)
    {
        $pr = ProjectRequirement::find($id);
        if($project)
        {
            return response()->json([
                'status' => 200,
                'project'=> $pr,
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
         $pr = ProjectRequirement::find($id);
        if($pr)
        {
            return response()->json([
                'status'=>200,
                'project'=>$pr,
            ]);
        }
        else
        {
            return response()->josn([
                'status'=>404,
                'message'=>'No project requirement found!',
            ]);
        }
    }


    public function update(Request $request, $id)
    {
       $validator = Validator::make($request->all(), [
            
 
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
            if($request->hasFile('image')){
                //get filename with the extension
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                // GET just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //get just ext
                $extension = $request->file('image')->getClientOriginalExtension();
                //filename to store
                $fileProjecName = $filename.'_'.time().'.'.$extension;
                //upload image
                $path = $request->file('image')->storeAs('public/project', $fileProjecName);

            } else {
                $fileProjecName = 'no.png';
            }

           
            $prs                = ProjectRequirement::find($id);
            $prs->des           = $request->des;
            $prs->image         = $fileProjecName;
            $prs->project_id    = $request->project_id;
            $prs->save();

            return response()->json([
                'status'=>200,
                'message'=> 'project Created Successfully!',
            ]);
        }
    }


    public function destroy($id)
    {
        $pr = ProjectRequirement::find($id);
        if($pr)
        {
            $pr->delete();
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
