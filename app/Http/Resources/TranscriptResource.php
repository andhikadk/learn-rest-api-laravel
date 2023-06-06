<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TranscriptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student_id' => $this->student_id,
            'student' => $this->student->name,
            'course' => $this->course_name,
            'credits' => $this->course_credits,
            'grade' => $this->course_grade,
            'gpa' => $this->student->gpa,
        ];
    }
}
