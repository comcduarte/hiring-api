<?php

declare(strict_types=1);

namespace Api\Job;

use Api\Job\Collection\JobCollection;
use Api\Job\Handler\Job\DeleteJobResourceHandler;
use Api\Job\Handler\Job\GetJobCollectionHandler;
use Api\Job\Handler\Job\GetJobResourceHandler;
use Api\Job\Handler\Job\PatchJobResourceHandler;
use Api\Job\Handler\Job\PostJobResourceHandler;
use Api\Job\Handler\Job\PutJobResourceHandler;
use Core\Job\Entity\Job;
use DateTimeImmutable;
use Fig\Http\Message\StatusCodeInterface;
use OpenApi\Attributes as OA;

/**
 * @see DeleteJobResourceHandler::handle()
 */
#[OA\Delete(
    path: '/job/{uuid}',
    description: 'Authenticated (super)admin deletes resource of type Job, identified by its UUID',
    summary: 'Admin deletes a resource of type Job',
    security: [['AuthToken' => []]],
    tags: ['Job'],
    parameters: [
        new OA\Parameter(
            name: 'uuid',
            description: 'Job UUID',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'string'),
        ),
    ],
    responses: [
        new OA\Response(
            response: StatusCodeInterface::STATUS_NO_CONTENT,
            description: 'Job has been deleted',
        ),
        new OA\Response(
            response: StatusCodeInterface::STATUS_NOT_FOUND,
            description: 'Not Found',
        ),
    ],
)]

/**
 * @see GetJobResourceHandler::handle()
 */
#[OA\Get(
    path: '/job/{uuid}',
    description: 'Authenticated (super)admin fetches a resource of type Job, identified by its UUID',
    summary: 'Admin fetches a resource of type Job',
    security: [['AuthToken' => []]],
    tags: ['Job'],
    parameters: [
        new OA\Parameter(
            name: 'uuid',
            description: 'Job UUID',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'string'),
        ),
    ],
    responses: [
        new OA\Response(
            response: StatusCodeInterface::STATUS_OK,
            description: 'Job account',
            content: new OA\JsonContent(ref: '#/components/schemas/Job'),
        ),
        new OA\Response(
            response: StatusCodeInterface::STATUS_NOT_FOUND,
            description: 'Not Found',
        ),
    ],
)]

/**
 * @see GetJobCollectionHandler::handle()
 */
#[OA\Get(
    path: '/job',
    description: 'Authenticated (super)admin fetches a list of Jobs',
    summary: 'Admin lists Jobs',
    security: [['AuthToken' => []]],
    tags: ['Job'],
    parameters: [
        new OA\Parameter(
            name: 'page',
            description: 'Page number',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer'),
            example: 1,
        ),
        new OA\Parameter(
            name: 'limit',
            description: 'Limit',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer'),
            example: 10,
        ),
        new OA\Parameter(
            name: 'order',
            description: 'Sort by field',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'string'),
            examples: [
                new OA\Examples(example: 'job.created', summary: 'Created', value: 'job.created'),
                new OA\Examples(example: 'job.updated', summary: 'Updated', value: 'job.updated'),
            ],
        ),
        new OA\Parameter(
            name: 'dir',
            description: 'Sort direction',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'string'),
            examples: [
                new OA\Examples(example: 'desc', summary: 'Sort descending', value: 'desc'),
                new OA\Examples(example: 'asc', summary: 'Sort ascending', value: 'asc'),
            ],
        ),
    ],
    responses: [
        new OA\Response(
            response: StatusCodeInterface::STATUS_OK,
            description: 'List of Jobs',
            content: new OA\JsonContent(ref: '#/components/schemas/JobCollection'),
        ),
        new OA\Response(
            response: StatusCodeInterface::STATUS_BAD_REQUEST,
            description: 'Bad Request',
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorMessage'),
        ),
        new OA\Response(
            response: StatusCodeInterface::STATUS_NOT_FOUND,
            description: 'Not Found',
        ),
    ],
)]

/**
 * @see PatchJobResourceHandler::handle()
 */
#[OA\Patch(
    path: '/job/{uuid}',
    description: 'Authenticated (super)admin updates an existing Job',
    summary: 'Admin updates an existing Job',
    security: [['AuthToken' => []]],
    requestBody: new OA\RequestBody(
        description: 'Update Job request',
        required: true,
        content: new OA\JsonContent(
            properties: [],
            type: 'object',
        ),
    ),
    tags: ['Job'],
    parameters: [
        new OA\Parameter(
            name: 'uuid',
            description: 'Job UUID',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'string'),
        ),
    ],
    responses: [
        new OA\Response(
            response: StatusCodeInterface::STATUS_OK,
            description: 'Job updated',
            content: new OA\JsonContent(ref: '#/components/schemas/Job'),
        ),
        new OA\Response(
            response: StatusCodeInterface::STATUS_BAD_REQUEST,
            description: 'Bad Request',
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorMessage'),
        ),
        new OA\Response(
            response: StatusCodeInterface::STATUS_CONFLICT,
            description: 'Conflict',
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorMessage'),
        ),
        new OA\Response(
            response: StatusCodeInterface::STATUS_NOT_FOUND,
            description: 'Not Found',
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorMessage'),
        ),
    ],
)]

/**
 * @see PostJobResourceHandler::handle()
 */
#[OA\Post(
    path: '/job',
    description: 'Authenticated (super)admin creates a new Job',
    summary: 'Admin creates a new Job',
    security: [['AuthToken' => []]],
    requestBody: new OA\RequestBody(
        description: 'Create Job request',
        required: true,
        content: new OA\JsonContent(
            required: [],
            properties: [],
            type: 'object',
        ),
    ),
    tags: ['Job'],
    responses: [
        new OA\Response(
            response: StatusCodeInterface::STATUS_CREATED,
            description: 'Job created',
            content: new OA\JsonContent(ref: '#/components/schemas/Job'),
        ),
        new OA\Response(
            response: StatusCodeInterface::STATUS_BAD_REQUEST,
            description: 'Bad Request',
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorMessage'),
        ),
        new OA\Response(
            response: StatusCodeInterface::STATUS_CONFLICT,
            description: 'Conflict',
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorMessage'),
        ),
        new OA\Response(
            response: StatusCodeInterface::STATUS_NOT_FOUND,
            description: 'Not Found',
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorMessage'),
        ),
    ],
)]

/**
 * @see PutJobResourceHandler::handle()
 */
#[OA\Put(
    path: '/job/{uuid}',
    description: 'Authenticated (super)admin replaces an existing Job',
    summary: 'Admin updates an existing Job',
    security: [['AuthToken' => []]],
    requestBody: new OA\RequestBody(
        description: 'Replace Job request',
        required: true,
        content: new OA\JsonContent(
            properties: [],
            type: 'object',
        ),
    ),
    tags: ['Job'],
    parameters: [
        new OA\Parameter(
            name: 'uuid',
            description: 'Job UUID',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'string'),
        ),
    ],
    responses: [
        new OA\Response(
            response: StatusCodeInterface::STATUS_OK,
            description: 'Job updated',
            content: new OA\JsonContent(ref: '#/components/schemas/Job'),
        ),
        new OA\Response(
            response: StatusCodeInterface::STATUS_BAD_REQUEST,
            description: 'Bad Request',
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorMessage'),
        ),
        new OA\Response(
            response: StatusCodeInterface::STATUS_CONFLICT,
            description: 'Conflict',
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorMessage'),
        ),
        new OA\Response(
            response: StatusCodeInterface::STATUS_NOT_FOUND,
            description: 'Not Found',
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorMessage'),
        ),
    ],
)]

/**
 * @see Job
 */
#[OA\Schema(
    schema: 'Job',
    properties: [
        new OA\Property(property: 'uuid', type: 'string', example: '1234abcd-abcd-4321-12ab-123456abcdef'),
        new OA\Property(property: 'created', type: 'object', example: new DateTimeImmutable()),
        new OA\Property(property: 'updated', type: 'object', example: new DateTimeImmutable()),
        new OA\Property(
            property: '_links',
            properties: [
                new OA\Property(
                    property: 'self',
                    properties: [
                        new OA\Property(
                            property: 'href',
                            type: 'string',
                            example: 'https://example.com/job/1234abcd-abcd-4321-12ab-123456abcdef',
                        ),
                    ],
                    type: 'object',
                ),
            ],
            type: 'object',
        ),
    ],
    type: 'object',
)]

/**
 * @see JobCollection
 */
#[OA\Schema(
    schema: 'JobCollection',
    properties: [
        new OA\Property(
            property: '_embedded',
            properties: [
                new OA\Property(
                    property: 'Jobs',
                    type: 'array',
                    items: new OA\Items(
                        ref: '#/components/schemas/Job',
                    ),
                ),
            ],
            type: 'object',
        ),
    ],
    type: 'object',
    allOf: [
        new OA\Schema(ref: '#/components/schemas/Collection'),
    ],
)]
class OpenAPI
{
}
