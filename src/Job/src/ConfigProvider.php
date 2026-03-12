<?php

declare(strict_types=1);

namespace Api\Job;

use Api\App\ConfigProvider as AppConfigProvider;
use Api\App\Factory\HandlerDelegatorFactory;
use Api\Job\Collection\JobCollection;
use Api\Job\Collection\JobTypeCollection;
use Api\Job\Handler\Job\DeleteJobResourceHandler;
use Api\Job\Handler\Job\GetJobCollectionHandler;
use Api\Job\Handler\Job\GetJobResourceHandler;
use Api\Job\Handler\Job\PatchJobResourceHandler;
use Api\Job\Handler\Job\PostJobResourceHandler;
use Api\Job\Handler\Job\PutJobResourceHandler;
use Api\Job\Handler\JobType\DeleteJobTypeResourceHandler;
use Api\Job\Handler\JobType\GetJobTypeCollectionHandler;
use Api\Job\Handler\JobType\GetJobTypeResourceHandler;
use Api\Job\Handler\JobType\PatchJobTypeResourceHandler;
use Api\Job\Handler\JobType\PostJobTypeResourceHandler;
use Api\Job\Handler\JobType\PutJobTypeResourceHandler;
use Api\Job\Service\JobService;
use Api\Job\Service\JobServiceInterface;
use Api\Job\Service\JobTypeService;
use Api\Job\Service\JobTypeServiceInterface;
use Core\Job\Entity\Job;
use Core\Job\Entity\JobType;
use Dot\DependencyInjection\Factory\AttributedServiceFactory;
use Mezzio\Application;
use Mezzio\Hal\Metadata\MetadataMap;

/**
 * @phpstan-import-type MetadataType from AppConfigProvider
 * @phpstan-type DependenciesType array{
 *     delegators: array<class-string, class-string[]>,
 *     factories: array<class-string, class-string>,
 *     aliases: array<class-string, class-string>,
 * }
 */
class ConfigProvider
{
    /**
     * @return array{
     *     dependencies: DependenciesType,
     *     "Mezzio\Hal\Metadata\MetadataMap": MetadataType[],
     * }
     */
    public function __invoke(): array
    {
        return [
            'dependencies'     => $this->getDependencies(),
            MetadataMap::class => $this->getHalConfig(),
        ];
    }

    /**
     * @return DependenciesType
     */
    private function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [RoutesDelegator::class],
                DeleteJobResourceHandler::class => [HandlerDelegatorFactory::class],
                GetJobResourceHandler::class => [HandlerDelegatorFactory::class],
                GetJobCollectionHandler::class => [HandlerDelegatorFactory::class],
                PatchJobResourceHandler::class => [HandlerDelegatorFactory::class],
                PostJobResourceHandler::class => [HandlerDelegatorFactory::class],
                PutJobResourceHandler::class => [HandlerDelegatorFactory::class],
                
                DeleteJobTypeResourceHandler::class => [HandlerDelegatorFactory::class],
                GetJobTypeResourceHandler::class => [HandlerDelegatorFactory::class],
                GetJobTypeCollectionHandler::class => [HandlerDelegatorFactory::class],
                PatchJobTypeResourceHandler::class => [HandlerDelegatorFactory::class],
                PostJobTypeResourceHandler::class => [HandlerDelegatorFactory::class],
                PutJobTypeResourceHandler::class => [HandlerDelegatorFactory::class],
            ],
            'factories'  => [
                //-- Job --//
                DeleteJobResourceHandler::class => AttributedServiceFactory::class,
                GetJobResourceHandler::class => AttributedServiceFactory::class,
                GetJobCollectionHandler::class => AttributedServiceFactory::class,
                PatchJobResourceHandler::class => AttributedServiceFactory::class,
                PostJobResourceHandler::class => AttributedServiceFactory::class,
                PutJobResourceHandler::class => AttributedServiceFactory::class,
                JobService::class => AttributedServiceFactory::class,
                
                //-- JobType --//
                JobTypeService::class => AttributedServiceFactory::class,
                DeleteJobTypeResourceHandler::class => AttributedServiceFactory::class,
                GetJobTypeResourceHandler::class => AttributedServiceFactory::class,
                GetJobTypeCollectionHandler::class => AttributedServiceFactory::class,
                PatchJobTypeResourceHandler::class => AttributedServiceFactory::class,
                PostJobTypeResourceHandler::class => AttributedServiceFactory::class,
                PutJobTypeResourceHandler::class => AttributedServiceFactory::class,
                
            ],
            'aliases'    => [
                JobServiceInterface::class => JobService::class,
                JobTypeServiceInterface::class => JobTypeService::class,
            ],
        ];
    }

    /**
     * @return MetadataType[]
     */
    private function getHalConfig(): array
    {
        return [
            AppConfigProvider::getCollection(JobCollection::class, 'job::list-job', 'Jobs'),
            AppConfigProvider::getCollection(JobTypeCollection::class, 'jobtype::list-jobtype', 'JobTypes'),
            AppConfigProvider::getResource(Job::class, 'job::view-job'),
            AppConfigProvider::getResource(JobType::class, 'jobtype::view-jobtype')
        ];
    }
}
