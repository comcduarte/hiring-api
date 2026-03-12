<?php

declare(strict_types=1);

namespace Api\Job\Handler\JobType;

use Api\App\Attribute\Resource;
use Api\App\Handler\AbstractHandler;
use Core\Job\Entity\JobType;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetJobTypeResourceHandler extends AbstractHandler
{
    #[Resource(entity: JobType::class)]
    public function handle(
        ServerRequestInterface $request,
    ): ResponseInterface {
        return $this->createResponse(
            $request,
            $request->getAttribute(JobType::class)
        );
    }
}
