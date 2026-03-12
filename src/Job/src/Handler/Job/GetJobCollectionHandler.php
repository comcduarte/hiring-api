<?php

declare(strict_types=1);

namespace Api\Job\Handler\Job;

use Api\App\Handler\AbstractHandler;
use Api\Job\Collection\JobCollection;
use Api\Job\Service\JobServiceInterface;
use Dot\DependencyInjection\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetJobCollectionHandler extends AbstractHandler
{
    #[Inject(
        JobServiceInterface::class,
    )]
    public function __construct(
        protected JobServiceInterface $jobService,
    ) {
    }

    public function handle(
        ServerRequestInterface $request,
    ): ResponseInterface {
        return $this->createResponse(
            $request,
            new JobCollection($this->jobService->getJobs($request->getQueryParams()))
        );
    }
}
