<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_notes; 
use App\Models\tbl_project;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Facades\File; 

class NoteController extends Controller
{
    //
    public $successStatus = 200;

    public function createNote(Request $request) {
      // logic to create a student record goes here
      $user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 

       $validator = Validator::make($request->all(), [ 
            'file' => 'required|mimes:jpeg,jpg,png,pdf', // max 10000kb', 
            'project_id' => 'required', 
            
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        if ($request->file->extension() != 'pdf') { 
           
		    $size = $request->file('file')->getSize();
         	$max = 10485760; // 10 MB , 1 MB = 1048576 
            if ($size > $max )
         	{  
         		return response()->json(['error'=>'The file must not be greater than 10 MB.'], 401); 
                
         	}          
        }

         if (!tbl_project::where('id', $request->project_id)->exists()) 
          {
                return response()->json(['error'=>'project_id is not found.Enter Valid project_id'], 404); 
          }

        // File Remname
        $date = Carbon::now();
        $d =  $date->toArray();
        $ext =$request->file->extension();  
        $name = $d['year'].$d['month'].$d['day'].'_'.$d['hour'].'_'.$d['minute'].'_'.$d['second'].'_'.rand(0, 999).'.'.$ext; 
        
        $files=$request->file('file');

         if($request->file->extension() != 'pdf')
         { 
       
		    $size = $request->file('file')->getSize();
         	$max = 3145728; // 3 MB
            if ($size > $max )
         	{  
         		// resize
                Image::make($files)->resize(700, 700)->save(public_path('file/'.$name));
         	}
         	else
	         {
	         	 $files->move('file',$name);
	         }  
         }
         else
         {
         	 $files->move('file',$name);
         }       

          $tbl_notes = new tbl_notes;
		  $tbl_notes->file = $name;
	      $tbl_notes->file_path = 'file/'.$name;
		  $tbl_notes->project_id = $request->project_id;
		  $tbl_notes->save();	

	    return response()->json(["message" => "Drawing record created"], 201);
	    
    }

    public function getAllNote(Request $request) {
      // logic to get all students goes here
        $user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 

    	$tbl_notes = tbl_notes::All(); 
    	
        return response()->json(['success' => $tbl_notes], $this-> successStatus);
        
    }

    public function getNote($id) {
      // logic to get a student record goes here
    	$user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 
		  if (tbl_notes::where('id', $id)->exists()) 
		  {
		  	  $tbl_notes = tbl_notes::find($id); 
              return response()->json(['success' => $tbl_notes], $this-> successStatus); 
		     
		  } 
		  else 
		  {
		       return response()->json(["message" => "Not Found"], 404);
		        
		  }
		  	
    }


    public function updateNote(Request $request, $id) {
      // logic to update a student record goes here
    	$user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 
		if (tbl_notes::where('id', $id)->exists())
		 {
                 $validator = Validator::make($request->all(), [ 
		            'file' => 'required|mimes:jpeg,jpg,png,pdf|required|max:10240', // max 10000kb', 
                    'project_id' => 'required', 
		             		            
		        ]);

		        if ($validator->fails()) { 
		            return response()->json(['error'=>$validator->errors()], 401);            
		        }

		         if (!tbl_project::where('id', $request->project_id)->exists()) 
		          {
		                return response()->json(['error'=>'project_id is not found.Enter Valid project_id'], 404); 
		          }

		         // File Remname
		        $date = Carbon::now();
		        $d =  $date->toArray();
		        $ext =$request->file->extension();  
		        $name = $d['year'].$d['month'].$d['day'].'_'.$d['hour'].'_'.$d['minute'].'_'.$d['second'].'_'.rand(0, 999).'.'.$ext; 
		        
		        $files=$request->file('file');

		         if($request->file->extension() != 'pdf')
		         { 
		       
				    $size = $request->file('file')->getSize();
		         	$max = 3145728; // 3 MB
		            if ($size > $max )
		         	{  
		         		// resize
		                Image::make($files)->resize(700, 700)->save(public_path('file/'.$name));
		         	}
		         	else
			         {
			         	 $files->move('file',$name);
			         }  
		         }
		         else
		         {
		         	 $files->move('file',$name);
		         }     

		        $tbl_notes = tbl_notes::find($id);
		        
                File::delete('file/'.$tbl_notes->file);

		        $tbl_notes->file = $name;
			    $tbl_notes->file_path = 'file/'.$name;
				$tbl_notes->project_id = $request->project_id;
				$tbl_notes->save();	

		        return response()->json(["message" => "records updated successfully"], 200);
		 }
		 else 
		 {
		        return response()->json(["message" => "menu not found"], 404);
		        
		 }
    }

    public function deleteNote ($id) {
      // logic to delete a student record goes here
       $user_auth  =  Auth::user();
        if (!$user_auth) 
         {
              return response()->json(['error'=>'Unauthorised'], 401);
         } 
    	if (tbl_notes::where('id', $id)->exists())
		 {
                 

		        $tbl_notes = tbl_notes::find($id);		        
		        File::delete('file/'.$tbl_notes->file);
		        $tbl_notes->delete();
                     

		        return response()->json(["message" => "records deleted successfully"], 200);
		 }
		 else 
		 {
		        return response()->json(["message" => "menu not found"], 404);
		        
		 }
    }
}
