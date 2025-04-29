<?php

namespace App\Http\Controllers;

use App\Http\Requests\authenticationRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for Authentication"
 * )
 */
class AuthenticationController extends Controller
{


    /**
 * @OA\Post(
 *     path="/api/v1/login",
 *     summary="Login student",
 *     tags={"Authentication Login"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="password123")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Login successful"),
 *     @OA\Response(response=401, description="Invalid credentials")
 * )
 */
    public function login(authenticationRequest $request){
        
        

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
            'expires_in' => now()->addMinutes(5)->toDateTimeString(),
        ], 200); 
    
    }


    /**
 * @OA\Post(
 *     path="/api/v1/logout",
 *     summary="Logout student",
 *     tags={"Authentication Logout"},
 *     security={{"passport":{}}},
 *     @OA\Response(response=200, description="Logout successful")
 * )
 */
    public function logout(Request $request){
        
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful',
        ], 200);
    }

}