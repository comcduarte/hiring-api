<?php

declare(strict_types=1);

namespace Api\Job\Handler\JobType;

use Api\App\Exception\BadRequestException;
use Api\App\Handler\AbstractHandler;
use Api\Job\InputFilter\CreateJobTypeInputFilter;
use Api\Job\Service\JobTypeServiceInterface;
use Core\App\Message;
use Dot\DependencyInjection\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostJobTypeResourceHandler extends AbstractHandler
{
    #[Inject(
        JobTypeServiceInterface::class,
        CreateJobTypeInputFilter::class,
    )]
    public function __construct(
        protected JobTypeServiceInterface $jobTypeService,
        protected CreateJobTypeInputFilter $inputFilter,
    ) {
    }

    /**
     * @throws BadRequestException
     */
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

        return $this->createdResponse($request, $this->jobTypeService->saveJobType($data));
    }
}
