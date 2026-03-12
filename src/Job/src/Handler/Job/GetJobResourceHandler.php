<?php

declare(strict_types=1);

namespace Api\Job\Handler\Job;

use Api\App\Attribute\Resource;
use Api\App\Handler\AbstractHandler;
use Core\Job\Entity\Job;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetJobResourceHandler extends AbstractHandler
{
    #[Resource(entity: Job::class)]
    public function handle(
        ServerRequestInterface $request,
    ): ResponseInterface {
        return $this->createResponse(
            $request,
            $request->getAttribute(Job::class)
        );
    }
}
