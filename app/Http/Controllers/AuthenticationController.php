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
 *     description="Authentication endpoints"
 * )
 */

class AuthenticationController extends Controller
{


/**
 * @OA\Post(
 *     path="/api/v1/login",
 *     summary="Login a student",
 *     description="Authenticates a student and returns a token",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login successful"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid credentials"
 *     )
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
 *     summary="Logout a student",
 *     description="Logs out the authenticated student",
 *     tags={"Authentication"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Logout successful"
 *     )
 * )
 */
public function logout(Request $request)
{
    try {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });            return response()->json(['message' => 'Logout successful'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Logout failed', 'error' => $e->getMessage()], 500);
    }
}

}