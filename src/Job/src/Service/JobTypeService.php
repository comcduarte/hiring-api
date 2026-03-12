<?php

declare(strict_types=1);

namespace Api\Job\Service;

use Core\App\Helper\Paginator;
use Core\Job\Entity\JobType;
use Core\Job\Repository\JobTypeRepository;
use Doctrine\ORM\QueryBuilder;
use Dot\DependencyInjection\Attribute\Inject;

use function in_array;

class JobTypeService implements JobTypeServiceInterface
{
    #[Inject(
        JobTypeRepository::class,
    )]
    public function __construct(
        protected JobTypeRepository $jobTypeRepository,
    ) {
    }

    public function getJobTypeRepository(): JobTypeRepository
    {
        return $this->jobTypeRepository;
    }

    public function deleteJobType(
        JobType $jobType,
    ): void {
        $this->jobTypeRepository->deleteResource($jobType);
    }

    /**
     * @param array<non-empty-string, mixed> $params
     */
    public function getJobTypes(
        array $params,
    ): QueryBuilder {
        $filters = $params['filters'] ?? [];
        $params  = Paginator::getParams($params, 'jobType.created');

        $sortableColumns = [
            'jobType.created',
            'jobType.updated',
        ];
        if (! in_array($params['sort'], $sortableColumns, true)) {
            $params['sort'] = 'jobType.created';
        }

        return $this->jobTypeRepository->getJobTypes($params, $filters);
    }

    /**
     * @param array<non-empty-string, mixed> $data
     */
    public function saveJobType(
        array $data,
        ?JobType $jobType = null,
    ): JobType {
        if (! $jobType instanceof JobType) {
            $jobType = new JobType();
            $jobType->exchangeArray($data);
        }

        $this->jobTypeRepository->saveResource($jobType);

        return $jobType;
    }
}
