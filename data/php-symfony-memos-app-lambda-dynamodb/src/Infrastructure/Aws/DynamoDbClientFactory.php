<?php

namespace App\Infrastructure\Aws;

use Aws\DynamoDb\DynamoDbClient;

class DynamoDbClientFactory
{
    public function __construct(
        private readonly string $region,
        private readonly ?string $endpoint = null,
        private readonly ?string $accessKeyId = null,
        private readonly ?string $secretAccessKey = null,
    ) {
    }

    public function __invoke(): DynamoDbClient
    {
        $config = [
            'version' => 'latest',
            'region' => $this->region,
        ];

        if ($this->endpoint) {
            $config['endpoint'] = $this->endpoint;
            $config['credentials'] = [
                'key' => $this->accessKeyId,
                'secret' => $this->secretAccessKey,
            ];
        }

        return new DynamoDbClient($config);
    }
}
