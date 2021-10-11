<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_profile; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class ProfileController extends Controller
{
    //

    public $successStatus = 200;

    public function createProfile(Request $request) {
      // logic to create a student record goes here
     $user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 

       $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }


	    $tbl_profile = new tbl_profile;
	    $tbl_profile->name = $request->name;
	    $tbl_profile->save();

	    return response()->json(["message" => "Profile record created"], 201);
	    
    }

    public function getAllProfile(Request $request) {
      // logic to get all students goes here
     	 $user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 

    	$tbl_profile = tbl_profile::All(); 
    	
        return response()->json(['success' => $tbl_profile], $this-> successStatus);
        
    }

    public function getProfile($id) {
      // logic to get a student record goes here
        $user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 

		  if (tbl_profile::where('id', $id)->exists()) 
		  {
		  	  $tbl_profile = tbl_profile::find($id); 
              return response()->json(['success' => $tbl_profile], $this-> successStatus); 
		     
		  } 
		  else 
		  {
		       return response()->json(["message" => "Profile not found"], 404);
		        
		  }
		  	
    }

    public function updateProfile(Request $request, $id) {
      // logic to update a student record goes here
       $user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 

		if (tbl_profile::where('id', $id)->exists())
		 {
                 $validator = Validator::make($request->all(), [ 
		            'name' => 'required', 
		            
		        ]);

		        if ($validator->fails()) { 
		            return response()->json(['error'=>$validator->errors()], 401);            
		        }

		        $tbl_profile = tbl_profile::find($id);
		        $tbl_profile->name = $request->name;
		        $tbl_profile->save();

		        return response()->json(["message" => "records updated successfully"], 200);
		 }
		 else 
		 {
		        return response()->json(["message" => "Profile not found"], 404);
		        
		 }
    }


    public function deleteProfile ($id) {
      // logic to delete a student record goes here
     	$user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 

    	if (tbl_profile::where('id', $id)->exists())
		 {
		        $tbl_profile = tbl_profile::find($id);
		        $tbl_profile->delete();


		        return response()->json(["message" => "records deleted successfully"], 200);
		 }
		 else 
		 {
		        return response()->json(["message" => "Profile not found"], 404);
		        
		 }
    }



}
