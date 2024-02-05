<?php

declare(strict_types=1);

namespace App\Tasks\Application\Actions;

use App\Tasks\Domain\JobRepositoryInterface;
use App\Tasks\Domain\Task;
use App\Tasks\Domain\TaskCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\UuidInterface;

class CreateTaskAction implements ShouldQueue
{
    use AsAction;

    private JobRepositoryInterface $jobRepository;

    public function __construct(JobRepositoryInterface $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function handle(Task $task, UuidInterface $jobId): void
    {
        $job = $this->jobRepository->get($jobId);
        $job->setAttribute('result', $task);
        $job->save();

        TaskCreated::dispatch($jobId, $job->getAttribute('result'));

        Log::info('CreateTaskAction: Job processed', ['job_id' => $jobId]);
    }
}
