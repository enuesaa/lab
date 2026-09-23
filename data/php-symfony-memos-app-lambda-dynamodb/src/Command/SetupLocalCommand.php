<?php

namespace App\Command;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'setup:local', description: 'Sets up the memos table in DynamoDB Local.')]
class SetupLocalCommand extends Command
{
    public function __construct(
        private readonly DynamoDbClient $client,
        private readonly string $tableName,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->client->describeTable(['TableName' => $this->tableName]);
            $io->success("Table \"{$this->tableName}\" already exists, nothing to do.");

            return 0;
        } catch (DynamoDbException $e) {
            if ('ResourceNotFoundException' !== $e->getAwsErrorCode()) {
                throw $e;
            }
        }

        $this->client->createTable([
            'TableName' => $this->tableName,
            'AttributeDefinitions' => [
                ['AttributeName' => 'pk', 'AttributeType' => 'S'],
                ['AttributeName' => 'sk', 'AttributeType' => 'S'],
            ],
            'KeySchema' => [
                ['AttributeName' => 'pk', 'KeyType' => 'HASH'],
                ['AttributeName' => 'sk', 'KeyType' => 'RANGE'],
            ],
            'BillingMode' => 'PAY_PER_REQUEST',
        ]);

        $this->client->waitUntil('TableExists', ['TableName' => $this->tableName]);

        $io->success("Table \"{$this->tableName}\" created.");

        return 0;
    }
}
