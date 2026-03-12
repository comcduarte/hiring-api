<?php

declare(strict_types=1);

namespace Api\Job\Handler\JobType;

use Api\App\Attribute\Resource;
use Api\App\Exception\BadRequestException;
use Api\App\Handler\AbstractHandler;
use Api\Job\InputFilter\ReplaceJobTypeInputFilter;
use Api\Job\Service\JobTypeServiceInterface;
use Core\App\Message;
use Core\Job\Entity\JobType;
use Dot\DependencyInjection\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PutJobTypeResourceHandler extends AbstractHandler
{
    #[Inject(
        JobTypeServiceInterface::class,
        ReplaceJobTypeInputFilter::class,
    )]
    public function __construct(
        protected JobTypeServiceInterface $jobTypeService,
        protected ReplaceJobTypeInputFilter $inputFilter,
    ) {
    }

    /**
     * @throws BadRequestException
     */
    #[Resource(entity: JobType::class)]
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
            $this->jobTypeService->saveJobType($data, $request->getAttribute(JobType::class))
        );
    }
}
