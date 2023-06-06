<?php

namespace App\Http\Controllers;

use App\Http\Resources\TranscriptResource;
use Illuminate\Http\Request;
use App\Repositories\TranscriptRepository;

class TranscriptController extends Controller
{
    private $transcriptRepository;

    public function __construct(TranscriptRepository $transcriptRepository)
    {
        $this->transcriptRepository = $transcriptRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $student = $request->query('student');

        if ($student) {
            $transcripts =  $this->transcriptRepository->getTranscriptsByStudent($student);
            return response()->json([
                'message' => 'Transcripts fetched successfully',
                'data' => TranscriptResource::collection($transcripts),
            ]);
        }

        $transcripts = $this->transcriptRepository->getTranscripts();
        return response()->json([
            'message' => 'Transcripts fetched successfully',
            'data' => TranscriptResource::collection($transcripts),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $transcript = $request->only([
            'student_id',
            'course_name',
            'course_credits',
            'course_grade'
        ]);

        try {
            $data = new TranscriptResource($this->transcriptRepository->createTranscript($transcript));

            return response()->json([
                'message' => 'Transcript created successfully',
                'data' => $data,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Transcript failed to create',
                'data' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transcript =  new TranscriptResource($this->transcriptRepository->getTranscriptById($id));

        return response()->json([
            'message' => 'Transcript fetched successfully',
            'data' => $transcript
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transcript = $request->only([
            'student_id',
            'course_name',
            'course_credits',
            'course_grade'
        ]);

        $data = new TranscriptResource($this->transcriptRepository->updateTranscript($transcript, $id));

        return response()->json([
            'message' => 'Transcript updated successfully',
            'data' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->transcriptRepository->deleteTranscript($id);

        return response()->json([
            'message' => 'Transcript deleted successfully'
        ], 200);
    }
}
