<?php

namespace App\Tasks\Domain;

use App\SharedKernel\DomainNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface JobRepositoryInterface
{
    public function create(): Job;

    public function save(Job $job): Job;

    /**
     * @param UuidInterface $uuid
     * @return Job
     * @throws DomainNotFoundException
     */
    public function get(UuidInterface $uuid): Job;
}
