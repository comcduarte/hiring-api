<?php

declare(strict_types=1);

namespace Api\Job\Handler\Job;

use Api\App\Attribute\Resource;
use Api\App\Handler\AbstractHandler;
use Api\Job\Service\JobServiceInterface;
use Core\Job\Entity\Job;
use Dot\DependencyInjection\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteJobResourceHandler extends AbstractHandler
{
    #[Inject(
        JobServiceInterface::class,
    )]
    public function __construct(
        protected JobServiceInterface $jobService,
    ) {
    }

    #[Resource(entity: Job::class)]
    public function handle(
        ServerRequestInterface $request,
    ): ResponseInterface {
        $this->jobService->deleteJob(
            $request->getAttribute(Job::class)
        );

        return $this->noContentResponse();
    }
}
