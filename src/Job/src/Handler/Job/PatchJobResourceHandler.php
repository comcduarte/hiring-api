<?php

declare(strict_types=1);

namespace Api\Job\Handler\Job;

use Api\App\Attribute\Resource;
use Api\App\Exception\BadRequestException;
use Api\App\Handler\AbstractHandler;
use Api\Job\InputFilter\EditJobInputFilter;
use Api\Job\Service\JobServiceInterface;
use Core\App\Message;
use Core\Job\Entity\Job;
use Dot\DependencyInjection\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PatchJobResourceHandler extends AbstractHandler
{
    #[Inject(
        JobServiceInterface::class,
        EditJobInputFilter::class,
    )]
    public function __construct(
        protected JobServiceInterface $jobService,
        protected EditJobInputFilter $inputFilter,
    ) {
    }

    /**
     * @throws BadRequestException
     */
    #[Resource(entity: Job::class)]
    public function handle(
        ServerRequestInterface $request,
    ): ResponseInterface {
        $this->inputFilter->setData((array) $request->getParsedBody());
        if (! $this->inputFilter->isValid()) {
            throw BadRequestException::create(
                detail: Message::VALIDATOR_INVALID_DATA,
                additional: ['errors' => $this->inputFilter->getMessages()]
            );
        }

        /** @var non-empty-array<non-empty-string, mixed> $data */
        $data = (array) $this->inputFilter->getValues();

        return $this->createResponse(
            $request,
            $this->jobService->saveJob($data, $request->getAttribute(Job::class))
        );
    }
}
