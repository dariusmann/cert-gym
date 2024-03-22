<?php

namespace App\Http\Controllers\Questions\Exam;

use App\Http\Controllers\Controller;
use App\Models\QuestionRunExam;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamStatusController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $exam = QuestionRunExam::where('completed', 0)->first();
        return new JsonResponse($exam);
    }
}
