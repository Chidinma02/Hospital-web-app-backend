<?php

namespace App\Http\Controllers\Api;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;



 // Import Passport

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::all();

        if ($hospitals->count() > 0) {
            return response()->json([
                'status' => 200,
                'hospitals' => $hospitals
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No hospitals found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Hospital_name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        $hashedPassword = Hash::make($request->password);

        $hospital = Hospital::create([
            'Hospital_name' => $request->Hospital_name,
            'email' => $request->email,
            'password' => $hashedPassword,
        ]);

        if ($hospital) {
            return response()->json([
                'status' => 200,
                'message' => "Hospital created successfully",
                'hospital' => $hospital,
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

   

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }



    public function listPatients(){
        if(auth()->user()){
            $myUserID = auth()->user()->id;
            // $myHospitalID = Hospital::find($myUserID->id)->id;
            $patientsList = User::where('hospital_id', $myUserID)->get();

            return response()->json([
                'status' => 200,
                'patients' => $patientsList,
            ]);
        }else{
            return response()->json([
                'status' => 201,
                'message' => "Please login",
            ]);
        }
    }
    
    

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        $user = Auth::user();
        $token = $user->createToken('AuthToken')->accessToken;

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function show()
    {
        $hospitals = Hospital::all();

        if ($hospitals->count() > 0) {
            $hospitalData = $hospitals->map(function ($hospital) {
                return [
                    'id' => $hospital->id,
                    'name' => $hospital->Hospital_name,
                ];
            });

            return response()->json([
                'status' => 200,
                'hospitals' => $hospitalData
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No hospitals found'
            ], 404);
        }
    }
}
