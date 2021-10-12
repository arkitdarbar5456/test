<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_permission;
use App\Models\tbl_profile; 
use App\Models\tbl_menu;  
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class PermissionController extends Controller
{
    //
     public $successStatus = 200;

    public function createPermission(Request $request) {
      // logic to create a student record goes here
        $user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 	

       $validator = Validator::make($request->all(), [ 
            'menu_id' => 'required', 
             'profile_id' => 'required',
             'user_id' => 'required',  
             'view_flag' => 'required', 
             'add_flag' => 'required', 
              'edit_flag' => 'required', 
              'delete_flag' => 'required',  
            
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

         if (!tbl_menu::where('id', $request->menu_id)->exists()) 
          {
                return response()->json(['error'=>'menu_id is not found.Enter Valid menu_id'], 404); 
          }
         if (!tbl_profile::where('id', $request->profile_id)->exists()) 
          {
                return response()->json(['error'=>'profile_id is not found.Enter Valid profile_id'], 404); 
          }
          if (!User::where('id', $request->user_id)->exists()) 
          {
                return response()->json(['error'=>'user_id is not found.Enter Valid user_id'], 404); 
          }



	    $tbl_permission = new tbl_permission;
	    $tbl_permission->menu_id = $request->menu_id;
	    $tbl_permission->profile_id = $request->profile_id;
	    $tbl_permission->user_id = $request->user_id;
	    $tbl_permission->view_flag = $request->view_flag;
	    $tbl_permission->add_flag = $request->add_flag;
	    $tbl_permission->edit_flag = $request->edit_flag;
	    $tbl_permission->delete_flag = $request->delete_flag;
	    $tbl_permission->save();

	    return response()->json(["message" => "permission record created"], 201);
	    
    }

    public function getAllPermission(Request $request) {
      // logic to get all students goes here
        $user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 
    	$tbl_permission = tbl_permission::All(); 
    	
        return response()->json(['success' => $tbl_permission], $this-> successStatus);
        
    }

    public function getPermission($id) {
      // logic to get a student record goes here
    	$user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 
		  if (tbl_permission::where('user_id', $id)->exists()) 
		  {
		  	  $tbl_permission = tbl_permission::where('user_id', $id)->get()->first(); 
              return response()->json(['success' => $tbl_permission], $this-> successStatus); 
		     
		  } 
		  else 
		  {
		       return response()->json(["message" => "Menu not found"], 404);
		        
		  }
		  	
    }


    public function updatePermission(Request $request, $id) {
      // logic to update a student record goes here
    	$user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 
		if (tbl_permission::where('id', $id)->exists())
		 {
               $validator = Validator::make($request->all(), [ 
		            'menu_id' => 'required', 
		             'profile_id' => 'required', 
		             'user_id' => 'required',  
		             'view_flag' => 'required', 
		             'add_flag' => 'required', 
		              'edit_flag' => 'required', 
		              'delete_flag' => 'required',  
		            
		        ]);

		        if ($validator->fails()) { 
		            return response()->json(['error'=>$validator->errors()], 401);            
		        }

		        if (!tbl_menu::where('id', $request->menu_id)->exists()) 
		          {
		                return response()->json(['error'=>'menu_id is not found.Enter Valid menu_id'], 404); 
		          }
		         if (!tbl_profile::where('id', $request->profile_id)->exists()) 
		          {
		                return response()->json(['error'=>'profile_id is not found.Enter Valid profile_id'], 404); 
		          }
		          if (!User::where('id', $request->user_id)->exists()) 
		          {
		                return response()->json(['error'=>'user_id is not found.Enter Valid user_id'], 404); 
		          }

		        $tbl_permission = tbl_permission::find($id);
		        $tbl_permission->menu_id = $request->menu_id;
			    $tbl_permission->profile_id = $request->profile_id;
			    $tbl_permission->user_id = $request->user_id;
			    $tbl_permission->view_flag = $request->view_flag;
			    $tbl_permission->add_flag = $request->add_flag;
			    $tbl_permission->edit_flag = $request->edit_flag;
			    $tbl_permission->delete_flag = $request->delete_flag;
			
		        $tbl_permission->save();

		        return response()->json(["message" => "records updated successfully"], 200);
		 }
		 else 
		 {
		        return response()->json(["message" => "permission not found"], 404);
		        
		 }
    }

    public function deletePermission ($id) {
      // logic to delete a student record goes here
       $user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 
    	if (tbl_permission::where('id', $id)->exists())
		 {
		        $tbl_permission = tbl_permission::where('user_id', $id);
		        $tbl_permission->delete();


		        return response()->json(["message" => "records deleted successfully"], 200);
		 }
		 else 
		 {
		        return response()->json(["message" => "permission not found"], 404);
		        
		 }
    }

}
