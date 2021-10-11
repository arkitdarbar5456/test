<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_menu; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class MenuController extends Controller
{
    //

    public $successStatus = 200;

    public function createMenu(Request $request) {
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


	    $tbl_menu = new tbl_menu;
	    $tbl_menu->name = $request->name;
	    $tbl_menu->save();

	    return response()->json(["message" => "Menu record created"], 201);
	    
    }

    public function getAllMenu(Request $request) {
      // logic to get all students goes here
        $user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 

    	$tbl_menu = tbl_menu::All(); 
    	
        return response()->json(['success' => $tbl_menu], $this-> successStatus);
        
    }

    public function getMenu($id) {
      // logic to get a student record goes here
    	$user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 
		  if (tbl_menu::where('id', $id)->exists()) 
		  {
		  	  $tbl_menu = tbl_menu::find($id); 
              return response()->json(['success' => $tbl_menu], $this-> successStatus); 
		     
		  } 
		  else 
		  {
		       return response()->json(["message" => "Menu not found"], 404);
		        
		  }
		  	
    }


    public function updateMenu(Request $request, $id) {

    	$user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 
      // logic to update a student record goes here
		if (tbl_menu::where('id', $id)->exists())
		 {
                 $validator = Validator::make($request->all(), [ 
		            'name' => 'required', 
		             
		            
		        ]);

		        if ($validator->fails()) { 
		            return response()->json(['error'=>$validator->errors()], 401);            
		        }

		        $tbl_menu = tbl_menu::find($id);
		        $tbl_menu->name = $request->name;
			
		        $tbl_menu->save();

		        return response()->json(["message" => "records updated successfully"], 200);
		 }
		 else 
		 {
		        return response()->json(["message" => "menu not found"], 404);
		        
		 }
    }

    public function deleteMenu ($id) {
      // logic to delete a student record goes here
    	$user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 

    	if (tbl_menu::where('id', $id)->exists())
		 {
		        $tbl_menu = tbl_menu::find($id);
		        $tbl_menu->delete();


		        return response()->json(["message" => "records deleted successfully"], 200);
		 }
		 else 
		 {
		        return response()->json(["message" => "menu not found"], 404);
		        
		 }
    }

   
}
