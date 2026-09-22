<?php

use App\Command\SetupLocalCommand;
use App\Repository\MemoRepository;
use Aws\DynamoDb\DynamoDbClient;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $services = $container->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\', '../src/');

    $services->set(DynamoDbClient::class)
        ->args([[]]);

    $services->set(MemoRepository::class)
        ->arg('$tableName', getenv('DYNAMODB_TABLE'));

    $services->set(SetupLocalCommand::class)
        ->arg('$tableName', getenv('DYNAMODB_TABLE'));
};
