<?php

declare(strict_types=1);

namespace Api\Job\Service;

use Core\App\Helper\Paginator;
use Core\Job\Entity\Job;
use Core\Job\Repository\JobRepository;
use Doctrine\ORM\QueryBuilder;
use Dot\DependencyInjection\Attribute\Inject;

use function in_array;

class JobService implements JobServiceInterface
{
    #[Inject(
        JobRepository::class,
    )]
    public function __construct(
        protected JobRepository $jobRepository,
    ) {
    }

    public function getJobRepository(): JobRepository
    {
        return $this->jobRepository;
    }

    public function deleteJob(
        Job $job,
    ): void {
        $this->jobRepository->deleteResource($job);
    }

    /**
     * @param array<non-empty-string, mixed> $params
     */
    public function getJobs(
        array $params,
    ): QueryBuilder {
        $filters = $params['filters'] ?? [];
        $params  = Paginator::getParams($params, 'job.created');

        $sortableColumns = [
            'job.created',
            'job.updated',
        ];
        if (! in_array($params['sort'], $sortableColumns, true)) {
            $params['sort'] = 'job.created';
        }

        return $this->jobRepository->getJobs($params, $filters);
    }

    /**
     * @param array<non-empty-string, mixed> $data
     */
    public function saveJob(
        array $data,
        ?Job $job = null,
    ): Job {
        if (! $job instanceof Job) {
            $job = new Job();
            $job->exchangeArray($data);
        }

        $this->jobRepository->saveResource($job);

        return $job;
    }
}
