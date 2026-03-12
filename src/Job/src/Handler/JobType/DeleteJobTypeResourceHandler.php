<?php

declare(strict_types=1);

namespace Api\Job\Handler\JobType;

use Api\App\Attribute\Resource;
use Api\App\Handler\AbstractHandler;
use Api\Job\Service\JobTypeServiceInterface;
use Core\Job\Entity\JobType;
use Dot\DependencyInjection\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteJobTypeResourceHandler extends AbstractHandler
{
    #[Inject(
        JobTypeServiceInterface::class,
    )]
    public function __construct(
        protected JobTypeServiceInterface $jobTypeService,
    ) {
    }

    #[Resource(entity: JobType::class)]
    public function handle(
        ServerRequestInterface $request,
    ): ResponseInterface {
        $this->jobTypeService->deleteJobType(
            $request->getAttribute(JobType::class)
        );

        return $this->noContentResponse();
    }
}
