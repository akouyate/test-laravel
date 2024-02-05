<?php

declare(strict_types=1);

namespace App\Tasks\Domain;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Ramsey\Uuid\UuidInterface;

class TaskCreated
{
    use Dispatchable, SerializesModels;

    public Task $taskData;
    public UuidInterface $jobId;

    public function __construct(UuidInterface $jobId, Task $task)
    {
        $this->taskData = $task;
        $this->jobId = $jobId;
    }
}
