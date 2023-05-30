<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Repositories\StudentRepository;
use Illuminate\Http\JsonResponse;
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
    public function index()
    {
        return $this->studentRepository->getStudents();
    }

    /**
     * Display a listing of the resource by major.
     */
    public function indexByMajor($majorId)
    {
        return $this->studentRepository->getStudentsByMajor($majorId);
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

        return response()->json([
            'message' => 'Student created successfully',
            'data' => $this->studentRepository->createStudent($student)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return $this->studentRepository->getStudentsById($student->id);
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

        return response()->json([
            'message' => 'Student updated successfully',
            'data' => $this->studentRepository->updateStudent($student, $studentId)
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
