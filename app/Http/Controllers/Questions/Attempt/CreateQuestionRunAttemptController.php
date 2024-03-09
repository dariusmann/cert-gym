<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questions\Attempt;

use App\Domain\Resolver\AnsweredCorrectlyResolver;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionAttempt;
use App\Models\QuestionResponse;
use App\Models\QuestionRunQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class CreateQuestionRunAttemptController extends Controller
{
    private AnsweredCorrectlyResolver $answeredCorrectlyResolver;

    public function __construct(
        AnsweredCorrectlyResolver $answeredCorrectlyResolver
    )
    {
        $this->answeredCorrectlyResolver = $answeredCorrectlyResolver;
    }

    // TODO: check if same user who request
    public function __invoke(Request $request): JsonResponse
    {
        $runQuestionId = $request->get('question_run_question_id');
        $answersIds = $request->get('answer_ids');

        /** @var User $user */
        $user = $request->user();

        /** @var QuestionRunQuestion $questionRunQuestion */
        $questionRunQuestion = QuestionRunQuestion::find($runQuestionId);

        if ($questionRunQuestion->getAttemptId() !== null) {
            throw new ConflictHttpException('Attempt already made for this run question');
        }

        $answeredCorrectly = $this->answeredCorrectlyResolver->resolve(
            $questionRunQuestion->getQuestionId(), $answersIds
        );

        /** @var QuestionAttempt $questionAttempt */
        $questionAttempt = QuestionAttempt::create([
            'question_id' => $questionRunQuestion->getQuestionId(),
            'user_id' => $user->getId(),
            'answered_correctly' => $answeredCorrectly
        ]);

        foreach ($answersIds as $answersId) {
            QuestionResponse::create([
                'attempt_id' => $questionAttempt->getId(),
                'answer_id' => $answersId
            ]);
        }

        $questionRunQuestion->setAttemptId($questionAttempt->getId());
        $questionRunQuestion->save();

        return new JsonResponse($questionRunQuestion);
    }
}
