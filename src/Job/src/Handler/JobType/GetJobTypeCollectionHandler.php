<?php

declare(strict_types=1);

namespace Api\Job\Handler\JobType;

use Api\App\Handler\AbstractHandler;
use Api\Job\Collection\JobTypeCollection;
use Api\Job\Service\JobTypeServiceInterface;
use Dot\DependencyInjection\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetJobTypeCollectionHandler extends AbstractHandler
{
    #[Inject(
        JobTypeServiceInterface::class,
    )]
    public function __construct(
        protected JobTypeServiceInterface $jobTypeService,
    ) {
    }

    public function handle(
        ServerRequestInterface $request,
    ): ResponseInterface {
        return $this->createResponse(
            $request,
            new JobTypeCollection($this->jobTypeService->getJobTypes($request->getQueryParams()))
        );
    }
}
