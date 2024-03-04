<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questions;

use App\Application\QuestionRun\ReadRandomRunHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class RunController extends Controller
{
    private ReadRandomRunHandler $handler;

    public function __construct(ReadRandomRunHandler $handler)
    {
        $this->handler = $handler;
    }

    public function readRandom(Request $request): JsonResponse
    {
        $user = $request->user();

        $questionRun = $this->handler->read($user);

        return new JsonResponse([
            'id' => $questionRun->getId()
        ]);
    }
}
