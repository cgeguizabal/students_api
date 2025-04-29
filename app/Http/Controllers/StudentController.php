<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
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
        return response()->json($student,200);       
    }

    //Creating new student
    public function newStudent(StudentRequest $request){
        $studentData = $request->validated();
        $studentData['password'] = Hash::make($studentData['password']);

        $student = Student::create($studentData);

        return response()->json(['message'=>'Successfully created', "student" => $student->toArray()],200);
        
    }

    //Updatin Student info
    public function
}