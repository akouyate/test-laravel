<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Storage\Postgres;

use App\SharedKernel\DomainNotFoundException;
use App\Tasks\Domain\JobRepositoryInterface;
use App\Tasks\Domain\Job;
use Ramsey\Uuid\UuidInterface;

class JobRepository implements JobRepositoryInterface
{
    public function create(): Job
    {

        return Job::create();
    }

    public function save(Job $job): Job
    {
        $job->save();

        return $job;
    }

    public function get(UuidInterface $uuid): Job
    {
        try {
            $job = Job::findOrFail($uuid->toString());

            return $job;
        } catch (ModelNotFoundException $e) {
            throw new DomainNotFoundException("Job with UUID {$uuid->toString()} not found.");
        }
    }
}
