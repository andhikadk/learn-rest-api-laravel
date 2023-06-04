<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentCollection;
use App\Models\Student;
use App\Repositories\StudentRepository;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $major = $request->query('major');

        if ($major) {
            $students =  $this->studentRepository->getStudentsByMajor($major);
            return StudentResource::collection($students);
        }

        $students = $this->studentRepository->getStudents();
        return new StudentCollection($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $student = $request->only([
            'name',
            'nim',
            'gender',
            'address',
            'major_id'
        ]);

        $data = new StudentResource($this->studentRepository->createStudent($student));

        return response()->json([
            'message' => 'Student created successfully',
            'data' => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $data =  new StudentResource($this->studentRepository->getStudentsById($student->id));

        return response()->json([
            'message' => 'Student fetched successfully',
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $studentId = $student->id;
        $student = $request->only([
            'name',
            'nim',
            'gender',
            'address',
            'major_id'
        ]);

        $data = new StudentResource($this->studentRepository->updateStudent($student, $studentId));

        return response()->json([
            'message' => 'Student updated successfully',
            'data' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $this->studentRepository->deleteStudent($student->id);

        return response()->json([
            'message' => 'Student deleted successfully'
        ], 200);
    }
}
