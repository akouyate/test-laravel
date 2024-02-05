<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Http\Controllers;

use App\Tasks\Application\Actions\CreateTaskAction;
use App\Tasks\Domain\JobRepositoryInterface;
use App\Tasks\Domain\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class CreateNewTask
{
    use AsAction;

    private JobRepositoryInterface $jobRepository;

    public function __construct(JobRepositoryInterface $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function rules(): array
    {
        return [
            'text' => 'required|string|max:255',
            'tasks' => 'required|array',
            'tasks.*' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Task::isValidTask($value)) {
                        $fail($attribute . ' is not a valid task.');
                    }
                }
            ]
        ];
    }

    public function handle(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());
        $task = $this->mapDataToTask($data);

        $job = $this->jobRepository->create();

        CreateTaskAction::dispatch($task, Uuid::fromString($job->uuid));

        return new JsonResponse(['id' => $job->uuid], Response::HTTP_CREATED);
    }

    public function asController(Request $request): JsonResponse
    {
        return $this->handle($request);
    }

    private function mapDataToTask(array $data): Task
    {
        $text = $data['text'];
        $tasks = $data['tasks'];

        return Task::createFromArray(['text'=> $text, 'types' => $tasks]);
    }
}
