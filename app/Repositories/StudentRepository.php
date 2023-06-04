<?php

namespace App\Repositories;

use App\Models\Student;
use App\Http\Resources\StudentResource;

class StudentRepository
{
    public function getStudents()
    {
        $students = Student::with('major')->orderByDesc('created_at')->paginate(5);
        return $students;
    }
    public function getStudentsByMajor($majorId)
    {
        $students = Student::where('major_id', $majorId)->with('major')->orderByDesc('created_at')->paginate(5);
        return $students;
    }
    public function createStudent(array $request)
    {
        return Student::create($request);
    }
    public function getStudentsById($id)
    {
        $student = Student::whereId($id)->with('major')->firstOrFail();
        return $student;
    }
    public function updateStudent(array $request, $id)
    {
        Student::whereId($id)->update($request);
        $student = Student::whereId($id)->with('major')->firstOrFail();
        return $student;
    }
    public function deleteStudent($id)
    {
        Student::destroy($id);
    }
}
