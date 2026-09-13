#!/usr/bin/env php
<?php

require dirname(__DIR__).'/vendor/autoload.php';

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;

$endpoint = getenv('DYNAMODB_ENDPOINT');

if (!$endpoint) {
    fwrite(STDERR, "DYNAMODB_ENDPOINT is not set; this script only targets DynamoDB Local.\n");
    exit(1);
}

$tableName = getenv('DYNAMODB_TABLE') ?: 'memos';

$client = new DynamoDbClient([
    'version' => 'latest',
    'region' => getenv('DYNAMODB_REGION') ?: 'us-east-1',
    'endpoint' => $endpoint,
    'credentials' => [
        'key' => getenv('AWS_ACCESS_KEY_ID') ?: 'local',
        'secret' => getenv('AWS_SECRET_ACCESS_KEY') ?: 'local',
    ],
]);

try {
    $client->describeTable(['TableName' => $tableName]);
    echo "Table \"{$tableName}\" already exists, nothing to do.\n";
    exit(0);
} catch (DynamoDbException $e) {
    if ('ResourceNotFoundException' !== $e->getAwsErrorCode()) {
        throw $e;
    }
}

$client->createTable([
    'TableName' => $tableName,
    'AttributeDefinitions' => [
        ['AttributeName' => 'id', 'AttributeType' => 'S'],
    ],
    'KeySchema' => [
        ['AttributeName' => 'id', 'KeyType' => 'HASH'],
    ],
    'BillingMode' => 'PAY_PER_REQUEST',
]);

$client->waitUntil('TableExists', ['TableName' => $tableName]);

echo "Table \"{$tableName}\" created.\n";
