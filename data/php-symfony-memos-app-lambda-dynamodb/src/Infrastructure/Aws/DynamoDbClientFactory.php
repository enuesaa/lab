<?php

namespace App\Infrastructure\Aws;

use Aws\DynamoDb\DynamoDbClient;

class DynamoDbClientFactory
{
    public static function create(
        string $region,
        ?string $endpoint = null,
        ?string $accessKeyId = null,
        ?string $secretAccessKey = null,
    ): DynamoDbClient {
        $config = [
            'version' => 'latest',
            'region' => $region,
        ];

        if ($endpoint) {
            $config['endpoint'] = $endpoint;
            $config['credentials'] = [
                'key' => $accessKeyId,
                'secret' => $secretAccessKey,
            ];
        }

        return new DynamoDbClient($config);
    }
}
