<?php


declare(strict_types=1);

namespace App\Tasks\Infrastructure\Http\Controllers;

use App\SharedKernel\DomainNotFoundException;
use App\Tasks\Domain\JobRepositoryInterface;
use App\Tasks\Infrastructure\Http\Response\TaskResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Lorisleiva\Actions\Concerns\AsAction;
use Ramsey\Uuid\Uuid;

class RetrieveTask
{
    use AsAction;

    private JobRepositoryInterface $jobRepository;

    public function __construct(JobRepositoryInterface $jobRepository)
    {

        $this->jobRepository = $jobRepository;
    }

    public function handle($jobId): JsonResponse
    {
        try {
            $job = $this->jobRepository->get(Uuid::fromString($jobId));

            return new JsonResponse(new TaskResponse($job));
        }catch (DomainNotFoundException $exception) {
            return new JsonResponse(['error' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

    }
}
