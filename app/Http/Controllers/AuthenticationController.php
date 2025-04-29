<?php

namespace App\Http\Controllers;

use App\Http\Requests\authenticationRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthenticationController extends Controller
{
    public function login(authenticationRequest $request){
        
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email',
        //     'password' => 'required|string|min:8',
        // ]);


        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => 'Validation error',
        //         'errors' => $validator->errors(),
        //     ], 422); 
        // }

        $studentData = $request->validated();



        $student = Student::where('email', $studentData['email'])->first();

        if (!$student || !Hash::check($studentData['password'], $student->password)) {
            return response()->json([
                'message' => 'Invalid credentials', 
            ], 401); 
        }

       
        $token = $student->createToken('StudentApp Personal Access')->accessToken; 

        

        
        return response()->json([
            'message' => 'Login successful',  
            'token' => $token,  
        ], 200); 
    
    }


}