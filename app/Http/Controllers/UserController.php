<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\tbl_profile;
use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller
{
    //

    public $successStatus = 200;

     public function demo(Request $request)
    { 

        // Get user of access token
        // $user_auth  =  Auth::user();
        // $token = $request->bearerToken(); 
       // if ( !empty ( $token ) ) {
       //          return ' token not empty';
       //   } 
       //   else
       //   {
       //      return 'token empty';
       //   }

         // if (!$user_auth) {
         //        return ' authorised';
         // } 
         // else
         // {
         //    return 'Unauthorised';
         // }
        if (User::where('id', 1)->exists()) 
            {
                  $user = User::where('id', 6)->get()->first();                             
                  if(!($user->type_id==2))
                  {
                        return response()->json(['error'=>'architect_id is not found.Enter Valid architect_id'], 404); 
                  }
            }
            else
            {
               return response()->json(['error'=>'architect_id is not found.Enter Valid architect_id'], 404); 
            }

    }

    public function login()
    { 
        if(Auth::attempt(['name' => request('name'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $user['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $user], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }


     public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'address' => 'required', 
            'contact_no' => 'required', 
            'type_id' => 'required', 
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        
         if (!tbl_profile::where('id', $request->type_id)->exists()) 
        {
             return response()->json(['error'=>'type_id is not found.Enter Valid type_id'], 404); 
        }

        $tbl_user = new User;
	    $tbl_user->name = $request->name;
	    $tbl_user->email = $request->email;
	    $tbl_user->password = $input['password'];
	    $tbl_user->address = $request->address;
	    $tbl_user->contact_no = $request->contact_no;
	    $tbl_user->type_id = $request->type_id;
	    $tbl_user->save();

        $success['token'] =  $tbl_user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $tbl_user->name;
        return response()->json(['success'=>$success], $this-> successStatus); 


    }

    public function getAllUser(Request $request) {
      // logic to get all students goes here
         $user_auth  =  Auth::user();
         if ($user_auth) 
         {
               $tbl_user = User::All();        
               return response()->json(['success' => $tbl_user], $this-> successStatus);
         } 
         else
         {
            return response()->json(['error'=>'Unauthorised'], 401);
         }

    	
        
    }

    public function getUser($id) {
      // logic to get a student record goes here
        $user_auth  =  Auth::user();
        if ($user_auth) 
         {
               if (User::where('id', $id)->exists()) 
              {
                  

                  $tbl_user = User::find($id); 
                  return response()->json(['success' => $tbl_user], $this-> successStatus); 
                 
              } 
              else 
              {
                   return response()->json(["error" => "User not found"], 404);
                    
              }
         } 
         else
         {
            return response()->json(['error'=>'Unauthorised'], 401);
         }
    		  
		  	
    }


    public function updateUser(Request $request, $id) {
      // logic to update a student record goes here
        $user_auth  =  Auth::user();
        if ($user_auth) 
         {
            if (User::where('id', $id)->exists())
             {

                    if (!tbl_profile::where('id', $request->type_id)->exists()) 
                    {
                         return response()->json(['error'=>'type_id is not found.Enter Valid type_id'], 404); 
                    }

                    $tbl_user = User::find($id);
                    $tbl_user->name = $request->name;
                    $tbl_user->email = $request->email;
                    $tbl_user->password =  bcrypt($request->password);
                    $tbl_user->address = $request->address;
                    $tbl_user->contact_no = $request->contact_no;
                    $tbl_user->type_id = $request->type_id;
                    $tbl_user->save();

                    return response()->json(["message" => "records updated successfully"], 200);
             }
             else 
             {
                    return response()->json(["message" => "User not found"], 404);
                    
             }
         } 
         else
         {
            return response()->json(['error'=>'Unauthorised'], 401);
         } 
    		
    }

    public function deleteUser ($id) {
      // logic to delete a student record goes here
       $user_auth  =  Auth::user();
        if ($user_auth) 
         {
               if (User::where('id', $id)->exists())
             {
                    $tbl_user = User::find($id);
                    $tbl_user->delete();


                    return response()->json(["message" => "records deleted successfully"], 200);
             }
             else 
             {
                    return response()->json(["message" => "User not found"], 404);
                    
             }
         } 
         else
         {
            return response()->json(['error'=>'Unauthorised'], 401);
         }

        	
    }

    public function getUser_Architect() {
      // logic to get a student record goes here
        $user_auth  =  Auth::user();
        if ($user_auth) 
         {    
             $id = 2;
               if (User::where('type_id', $id)->exists()) 
              {
                  

                  $tbl_user = User::where('type_id', $id)->get(); 
                  return response()->json(['success' => $tbl_user], $this-> successStatus); 
                 
              } 
              else 
              {
                   return response()->json(["error" => "User not found"], 404);
                    
              }
         } 
         else
         {
            return response()->json(['error'=>'Unauthorised'], 401);
         }
              
            
    }


    public function getUser_PMC() {
      // logic to get a student record goes here
        $user_auth  =  Auth::user();
        if ($user_auth) 
         {    
             $id = 3;
               if (User::where('type_id', $id)->exists()) 
              {
                  

                  $tbl_user = User::where('type_id', $id)->get(); 
                  return response()->json(['success' => $tbl_user], $this-> successStatus); 
                 
              } 
              else 
              {
                   return response()->json(["error" => "User not found"], 404);
                    
              }
         } 
         else
         {
            return response()->json(['error'=>'Unauthorised'], 401);
         }
              
              
            
    }

    public function getUser_Client() {
      // logic to get a student record goes here
         $user_auth  =  Auth::user();
        if ($user_auth) 
         {    
             $id = 4;
               if (User::where('type_id', $id)->exists()) 
              {
                  

                  $tbl_user = User::where('type_id', $id)->get(); 
                  return response()->json(['success' => $tbl_user], $this-> successStatus); 
                 
              } 
              else 
              {
                   return response()->json(["error" => "User not found"], 404);
                    
              }
         } 
         else
         {
            return response()->json(['error'=>'Unauthorised'], 401);
         }
              
              
            
    }




}
