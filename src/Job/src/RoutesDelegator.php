<?php

declare(strict_types=1);

namespace Api\Job;

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
use Core\App\ConfigProvider;
use Dot\Router\RouteCollectorInterface;
use Mezzio\Application;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class RoutesDelegator
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $container,
        string $serviceName,
        callable $callback,
    ): Application {
        $uuid = ConfigProvider::REGEXP_UUID;

        /** @var RouteCollectorInterface $routeCollector */
        $routeCollector = $container->get(RouteCollectorInterface::class);

        $routeCollector
            ->delete('/job/' . $uuid, DeleteJobResourceHandler::class, 'job::delete-job')
            ->get('/job/' . $uuid, GetJobResourceHandler::class, 'job::view-job')
            ->get('/job', GetJobCollectionHandler::class, 'job::list-job')
            ->patch('/job/' . $uuid, PatchJobResourceHandler::class, 'job::update-job')
            ->post('/job', PostJobResourceHandler::class, 'job::create-job')
            ->put('/job/' . $uuid, PutJobResourceHandler::class, 'job::replace-job');
        
        $routeCollector->group('/jobtype')
            ->delete($uuid, DeleteJobTypeResourceHandler::class, 'jobtype::delete-jobtype')
            ->get($uuid, GetJobTypeResourceHandler::class, 'jobtype::view-jobtype')
            ->get('', GetJobTypeCollectionHandler::class, 'jobtype::list-jobtype')
            ->patch($uuid, PatchJobTypeResourceHandler::class, 'jobtype::update-jobtype')
            ->post('', PostJobTypeResourceHandler::class, 'jobtype::create-jobtype')
            ->put($uuid, PutJobTypeResourceHandler::class, 'jobtype::replace-jobtype');

        return $callback();
    }
}
