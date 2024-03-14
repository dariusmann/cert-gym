<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questions\Run;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\QuestionRun;
use Illuminate\Http\JsonResponse;

class ReadUserQuestionRunController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        
        $questionRuns = QuestionRun::where('user_id', $request->user()->getId())
        ->where('type', '!=', 'random')
        ->orderByDesc('created_at')->get();
        $responseData = $questionRuns->map(function ($questionRun) {
            return $questionRun->jsonSerialize();
        });
        
        return new JsonResponse($responseData);
    }
}
