<?php

namespace App\Repositories;

use App\Models\Student;
use App\Models\Transcript;
use Illuminate\Support\Facades\DB;

class TranscriptRepository
{
    public function getTranscripts()
    {
        $transcripts = Transcript::with('student')->get();
        return $transcripts;
    }
    public function getTranscriptsByStudent($studentId)
    {
        $transcripts = Transcript::where('student_id', $studentId)->with('student')->get();
        return $transcripts;
    }
    public function createTranscript(array $request)
    {
        DB::beginTransaction();

        // Create transcript
        $data = Transcript::create($request);

        // Update student GPA
        $student = Student::find($request['student_id']);
        $student->gpa = $student->transcripts()->avg('course_grade');
        $student->save();

        DB::commit();
        return $data;
    }
    public function getTranscriptById($id)
    {
        $transcript = Transcript::whereId($id)->with('student')->firstOrFail();
        return $transcript;
    }
    public function updateTranscript(array $request, $id)
    {
        DB::beginTransaction();

        // Update transcript
        $transcript = Transcript::whereId($id)->with('student')->firstOrFail();
        Transcript::whereId($id)->update($request);

        // Update student GPA
        $student = Student::find($transcript->student_id);
        $student->gpa = $student->transcripts()->avg('course_grade');
        $student->save();

        DB::commit();
        return $transcript;
    }
    public function deleteTranscript($id)
    {
        Transcript::destroy($id);
    }
}
