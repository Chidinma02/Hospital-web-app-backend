<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{/**
 * @OA\Get(
 *     path="/api/student",
 *     tags={"users"},
 *     summary="Retrieve all users",
 *     description="Retrieve a list of all users",
 *     operationId="getAllUsers",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/User")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No users found"
 *     )
 * )
 */


 public function index()
 {
     // Fetch users from the database or any other data source
     $users = User::all();
 
     // Check if any users are found
     if ($users->count() > 0) {
         return response()->json([
             'status' => 200,
             'users' => $users
         ], 200);
     } else {
         return response()->json([
             'status' => 404,
             'message' => 'No users found'
         ], 404);
     }
 }
 

    public function store(Request $request)
{
    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'dob' => 'required|date',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:255',
        'hospital_id' => 'required|integer|max:255',
        'sex' => 'required|string|min:1',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
        ], 422);
    }

    // Create a new user with the provided data
    $user =new User;
    $user->hospital_id = $request->hospital_id;
    $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->dob = $request->dob;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->sex =  $request->sex;
        // $user = $user->save();
    // $user = User::create([
    //     'hospital_id' => $request->hospital_id,
    //     'first_name' => $request->first_name,
    //     'last_name' => $request->last_name,
    //     'dob' => $request->dob,
    //     'email' => $request->email,
    //     'phone' => $request->phone,
    //     'sex' =>  $request->sex,
        
    // ]);

    // Check if user creation was successful
    if ($user->save()) {
        return response()->json([
            'status' => 200,
            'message' => "User created successfully"
        ], 200);
    } else {
        return response()->json([
            'status' => 500,
            'message' => 'Something went wrong'
        ], 500);
    }
}

   
   }