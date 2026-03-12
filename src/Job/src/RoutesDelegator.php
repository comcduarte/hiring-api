<?php

declare(strict_types=1);

namespace Api\Job;

use Api\Job\Handler\Job\DeleteJobResourceHandler;
use Api\Job\Handler\Job\GetJobCollectionHandler;
use Api\Job\Handler\Job\GetJobResourceHandler;
use Api\Job\Handler\Job\PatchJobResourceHandler;
use Api\Job\Handler\Job\PostJobResourceHandler;
use Api\Job\Handler\Job\PutJobResourceHandler;
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

        return $callback();
    }
}
