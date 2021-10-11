<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_status_report; 
use App\Models\tbl_project;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Facades\File; 

class Status_report_Controller extends Controller
{
    //
    public $successStatus = 200;

    public function createStatus_report(Request $request) {
      // logic to create a student record goes here
    	$user_auth  =  Auth::user();
        if ($user_auth) 
         {
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

	          $tbl_status_report = new tbl_status_report;
			  $tbl_status_report->file = $name;
		      $tbl_status_report->file_path = 'file/'.$name;
			  $tbl_status_report->project_id = $request->project_id;
			  $tbl_status_report->save();	

		    return response()->json(["message" => "photo record created"], 201);
         } 
         else
         {
            return response()->json(['error'=>'Unauthorised'], 401);
         }
	      
	    
    }

    public function getAllStatus_report(Request $request) {
      // logic to get all students goes here
    	$user_auth  =  Auth::user();
        if ($user_auth) 
         {
             $tbl_status_report = tbl_status_report::All(); 	    	
	        return response()->json(['success' => $tbl_status_report], $this-> successStatus);
         } 
         else
         {
            return response()->json(['error'=>'Unauthorised'], 401);
         }

	    	
        
    }

    public function getStatus_report($id) {
      // logic to get a student record goes here
    	$user_auth  =  Auth::user();
        if ($user_auth) 
         {
               if (tbl_status_report::where('id', $id)->exists()) 
			  {
			  	  $tbl_status_report = tbl_status_report::find($id); 
	              return response()->json(['success' => $tbl_status_report], $this-> successStatus); 
			     
			  } 
			  else 
			  {
			       return response()->json(["message" => "Not Found"], 404);
			        
			  }
         } 
         else
         {
            return response()->json(['error'=>'Unauthorised'], 401);
         }
			  
		  	
    }


    public function updateStatus_report(Request $request, $id) {
      // logic to update a student record goes here
    	$user_auth  =  Auth::user();
        if ($user_auth) 
         {
             if (tbl_status_report::where('id', $id)->exists())
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

			        $tbl_status_report = tbl_status_report::find($id);
			        
	                File::delete('file/'.$tbl_status_report->file);

			        $tbl_status_report->file = $name;
				    $tbl_status_report->file_path = 'file/'.$name;
					$tbl_status_report->project_id = $request->project_id;
					$tbl_status_report->save();	

			        return response()->json(["message" => "records updated successfully"], 200);
			 }
			 else 
			 {
			        return response()->json(["message" => "menu not found"], 404);
			        
			 }
          }
         
         else
         {
            return response()->json(['error'=>'Unauthorised'], 401);
         }
     }    
			

    public function deleteStatus_report ($id) {
      // logic to delete a student record goes here
    	$user_auth  =  Auth::user();
        if ($user_auth) 
         {
               if (tbl_status_report::where('id', $id)->exists())
			 {
	                 

			        $tbl_status_report = tbl_status_report::find($id);		        
			        File::delete('file/'.$tbl_status_report->file);
			        $tbl_status_report->delete();
	                     

			        return response()->json(["message" => "records deleted successfully"], 200);
			 }
			 else 
			 {
			        return response()->json(["message" => "menu not found"], 404);
			        
			 }
         } 
         else
         {
            return response()->json(['error'=>'Unauthorised'], 401);
         }

	    	
    }
}
