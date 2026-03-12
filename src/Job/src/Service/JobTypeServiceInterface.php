<?php

declare(strict_types=1);

namespace Api\Job\Service;

use Core\Job\Entity\JobType;
use Core\Job\Repository\JobTypeRepository;
use Doctrine\ORM\QueryBuilder;

interface JobTypeServiceInterface
{
    public function getJobTypeRepository(): JobTypeRepository;

    public function deleteJobType(
        JobType $jobType,
    ): void;

    /**
     * @param array<non-empty-string, mixed> $params
     */
    public function getJobTypes(
        array $params,
    ): QueryBuilder;

    /**
     * @param array<non-empty-string, mixed> $data
     */
    public function saveJobType(
        array $data,
        ?JobType $jobType = null,
    ): JobType;
}
