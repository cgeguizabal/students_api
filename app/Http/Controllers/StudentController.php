<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Requests\updateStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    //Getting all students
    public function index(){
        $students = Student::all();
        
        if(count($students)>0){
            return response()->json($students, 200);
        }

        return response()->json([], 204);
    }

    //Getting Students by ID
    public function studentByID($id){

        $validator = Validator::make(['id' => $id],['id' => 'required|integer|exists:students,id']);

        if($validator -> fails()){
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student = Student::find($id);
        return response()->json($student,302);       
    }

    //Creating new student
    public function newStudent(StudentRequest $request){
        $studentData = $request->validated();
        $studentData['password'] = Hash::make($studentData['password']);

        $student = Student::create($studentData);

        return response()->json(['message'=>'Successfully created', "student" => $student->toArray()],201);
        
    }

    //Updating Student info
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
    public function deleteStudent($id){
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->delete();

        return response()->json(['message'=>'Student has been deleted successfully'], 200);
    }
    
}