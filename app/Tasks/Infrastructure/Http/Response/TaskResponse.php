<?php

namespace App\Tasks\Infrastructure\Http\Response;

use App\Tasks\Domain\Job;

class TaskResponse implements \JsonSerializable
{
    private Job $job;

    public function __construct(Job $job)
    {

        $this->job = $job;
    }

    public function jsonSerialize(): array
    {
        $task = $this->job->getAttribute('result');

        return [
           'id' => $this->job->uuid,
           'text' => $task->getText(),
           'tasks' => $task->getTypes()
        ];
    }
}
