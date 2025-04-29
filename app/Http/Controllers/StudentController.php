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
 *     description="Operations related to students"
 * )
 */


class StudentController extends Controller
{

    //Getting all students

    /**
 * @OA\Get(
 *     path="/api/v1/students",
 *     summary="Get all students",
 *     tags={"Students"},
 *     security={{"passport":{}}},
 *     @OA\Response(response=200, description="List of students"),
 *     @OA\Response(response=204, description="No students found")
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
 *     path="/api/v1/student/{id}",
 *     summary="Get student by ID",
 *     tags={"Students by ID"},
 *     security={{"passport":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the student",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=302, description="Student found"),
 *     @OA\Response(response=404, description="Student not found")
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
 *     path="/api/v1/newStudent",
 *     summary="Create a new student",
 *     tags={"New Student"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/Student")
 *     ),
 *     @OA\Response(response=201, description="Successfully created"),
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
 *     path="/api/v1/updateStudentInfo/{id}",
 *     summary="Update student information",
 *     tags={"Update Student"},
 *     security={{"passport":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the student",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/Student")
 *     ),
 *     @OA\Response(response=200, description="Student updated successfully")
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

    //Deleting Student
    /**
 * @OA\Delete(
 *     path="/api/v1/deleteStudent/{id}",
 *     summary="Delete a student",
 *     tags={"Delete Student"},
 *     security={{"passport":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the student",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Student deleted successfully"),
 *     @OA\Response(response=404, description="Student not found")
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