<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Requests\updateStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



/**
 * @OA\Tag(
 *     name="Students",
 *     description="Operations about students"
 * )
 */

 


class StudentController extends Controller
{

    //Getting all students

 /**
 * @OA\Get(
 *     path="/api/v1/students",
 *     summary="Get all students",
 *     description="Returns a list of all registered students",
 *     tags={"Students"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of students successfully obtained"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No students registered"
 *     )
 * )
 */
    public function index(){
        $students = Student::all();
        
        if(count($students)>0){
            return response()->json($students, 200);
        }

        return response()->json([], 204);
    }

    //Getting Students by ID
    /**
 * @OA\Get(
 *     path="/api/v1/students/{id}",
 *     summary="Get student by ID",
 *     description="Returns a student by the given ID",
 *     tags={"Students"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Student ID",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Student found"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Student not found"
 *     )
 * )
 */
    public function studentByID($id){

        $validator = Validator::make(['id' => $id],['id' => 'required|integer|exists:students,id']);

        if($validator -> fails()){
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student = Student::find($id);
        return response()->json($student,302);       
    }

    //Creating new student
   
/**
 * @OA\Post(
 *     path="/api/v1/students",
 *     summary="Register a new student",
 *     description="Registers a new student in the system",
 *     tags={"Students"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"firstName", "lastName", "age", "grade", "email", "phone_number", "password"},
 *             @OA\Property(property="firstName", type="string", example="John"),
 *             @OA\Property(property="lastName", type="string", example="Doe"),
 *             @OA\Property(property="age", type="integer", example=20),
 *             @OA\Property(property="grade", type="integer", example=10),
 *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *             @OA\Property(property="phone_number", type="string", example="123456789"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Student successfully created"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     )
 * )
 */
    public function newStudent(StudentRequest $request){
        $studentData = $request->validated();
        $studentData['password'] = Hash::make($studentData['password']);

        $student = Student::create($studentData);

        return response()->json(['message'=>'Successfully created', "student" => $student->toArray()],201);
        
    }

    //Updating Student info
  /**
 * @OA\Patch(
 *     path="/api/v1/students/{id}",
 *     summary="Update student information",
 *     description="Updates the information of a specific student",
 *     tags={"Students"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Student ID",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=false,
 *         @OA\JsonContent(
 *             @OA\Property(property="firstName", type="string", example="John"),
 *             @OA\Property(property="lastName", type="string", example="Doe"),
 *             @OA\Property(property="age", type="integer", example=21),
 *             @OA\Property(property="grade", type="integer", example=11),
 *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *             @OA\Property(property="phone_number", type="string", example="123456789"),
 *             @OA\Property(property="password", type="string", example="newpassword123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Student successfully updated"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Student not found"
 *     )
 * )
 */
    public function updateStudentInfo(updateStudentRequest $request, $id){
        $student = Student::find($id);
        
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
    
        $student->update($data);

        return response()->json(['message' => 'Student information successfully updated'], 200);

        
    }

 /**
 * @OA\Delete(
 *     path="/api/v1/students/{id}",
 *     summary="Delete a student",
 *     description="Deletes a student from the system by ID",
 *     tags={"Students"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Student ID",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Student successfully deleted"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Student not found"
 *     )
 * )
 */
    public function deleteStudent($id){
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->delete();

        return response()->json(['message'=>'Student has been deleted successfully'], 200);
    }
    
}