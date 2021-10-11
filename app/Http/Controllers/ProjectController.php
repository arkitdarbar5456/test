<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_project; 
use App\Models\tbl_profile; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class ProjectController extends Controller
{
    //
     public $successStatus = 200;

    public function createProject(Request $request) {
      // logic to create a student record goes here
        $user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 

	       $validator = Validator::make($request->all(), [ 
	            'name' => 'required', 
	            'address' => 'required', 
	            'architect_id' => 'required', 
	            'pmc_id' => 'required', 
	            'client_id' => 'required', 
	            
	        ]);

	        if ($validator->fails()) { 
	            return response()->json(['error'=>$validator->errors()], 401);            
	        }

	        if (!tbl_profile::where('id', $request->architect_id)->exists()) 
	          {
	                return response()->json(['error'=>'architect_id is not found.Enter Valid architect_id'], 404); 
	          }
	        
	        if (!tbl_profile::where('id', $request->pmc_id)->exists()) 
	          {
	                return response()->json(['error'=>'pmc_id is not found.Enter Valid pmc_id'], 404); 
	          }

	         if (!tbl_profile::where('id', $request->client_id)->exists()) 
	          {
	                return response()->json(['error'=>'client_id is not found.Enter Valid client_id'], 404); 
	          }  


		    $tbl_project = new tbl_project;
		    $tbl_project->name = $request->name;
		    $tbl_project->address = $request->address;
		    $tbl_project->architect_id = $request->architect_id;
		    $tbl_project->pmc_id = $request->pmc_id;
		    $tbl_project->client_id = $request->client_id;
		    $tbl_project->save();

		    return response()->json(["message" => "Project record created"], 201);
	    
    }


    public function getAllProject(Request $request) {
      // logic to get all students goes here
        $user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 
	    	$tbl_project = tbl_project::All(); 
	    	
	        return response()->json(['success' => $tbl_project], $this-> successStatus);
        
    }

    public function getProject($id) {
      // logic to get a student record goes here
	    	 $user_auth  =  Auth::user();
	        if (!$user_auth) 
	         {
	              return response()->json(['error'=>'Unauthorised'], 401);
	         } 
			  if (tbl_project::where('id', $id)->exists()) 
			  {
			  	  $tbl_project = tbl_project::find($id); 
	              return response()->json(['success' => $tbl_project], $this-> successStatus); 
			     
			  } 
			  else 
			  {
			       return response()->json(["message" => "Project not found"], 404);
			        
			  }
		  	
    }

    public function updateProject(Request $request, $id) {
      // logic to update a student record goes here
    	$user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 
		if (tbl_project::where('id', $id)->exists())
			 {
	                  $validator = Validator::make($request->all(), [ 
			            'name' => 'required', 
			            'address' => 'required', 
			            'architect_id' => 'required', 
			            'pmc_id' => 'required', 
			            'client_id' => 'required', 
			            
			        ]);

			        if ($validator->fails()) { 
			            return response()->json(['error'=>$validator->errors()], 401);            
			        }

					 if (!tbl_profile::where('id', $request->architect_id)->exists()) 
			          {
			                return response()->json(['error'=>'architect_id is not found.Enter Valid architect_id'], 404); 
			          }
			        
			        if (!tbl_profile::where('id', $request->pmc_id)->exists()) 
			          {
			                return response()->json(['error'=>'pmc_id is not found.Enter Valid pmc_id'], 404); 
			          }

			         if (!tbl_profile::where('id', $request->client_id)->exists()) 
			          {
			                return response()->json(['error'=>'client_id is not found.Enter Valid client_id'], 404); 
			          }  

			        $tbl_project = tbl_project::find($id);
			        $tbl_project->name = $request->name;
				    $tbl_project->address = $request->address;
				    $tbl_project->architect_id = $request->architect_id;
				    $tbl_project->pmc_id = $request->pmc_id;
				    $tbl_project->client_id = $request->client_id;
				    $tbl_project->save();

			        return response()->json(["message" => "records updated successfully"], 200);
			 }
			 else 
			 {
			        return response()->json(["message" => "project not found"], 404);
			        
			 }
    }

    public function deleteProject ($id) {
      // logic to delete a student record goes here
        $user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         }    
	    	if (tbl_project::where('id', $id)->exists())
			 {
			        $tbl_project = tbl_project::find($id);
			        $tbl_project->delete();


			        return response()->json(["message" => "records deleted successfully"], 200);
			 }
			 else 
			 {
			        return response()->json(["message" => "project id not found"], 404);
			        
			 }
    }
}
