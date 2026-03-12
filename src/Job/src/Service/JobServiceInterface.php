<?php

declare(strict_types=1);

namespace Api\Job\Service;

use Core\Job\Entity\Job;
use Core\Job\Repository\JobRepository;
use Doctrine\ORM\QueryBuilder;

interface JobServiceInterface
{
    public function getJobRepository(): JobRepository;

    public function deleteJob(
        Job $job,
    ): void;

    /**
     * @param array<non-empty-string, mixed> $params
     */
    public function getJobs(
        array $params,
    ): QueryBuilder;

    /**
     * @param array<non-empty-string, mixed> $data
     */
    public function saveJob(
        array $data,
        ?Job $job = null,
    ): Job;
}
