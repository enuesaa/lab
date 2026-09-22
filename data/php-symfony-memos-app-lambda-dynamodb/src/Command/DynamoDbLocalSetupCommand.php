<?php

namespace App\Command;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(name: 'app:dynamodb-local:setup', description: 'Creates the memos table in DynamoDB Local, if it does not already exist.')]
class DynamoDbLocalSetupCommand extends Command
{
    public function __construct(
        private readonly DynamoDbClient $client,
        #[Autowire(env: 'DYNAMODB_TABLE')]
        private readonly string $tableName,
        #[Autowire(env: 'default::DYNAMODB_ENDPOINT')]
        private readonly ?string $endpoint,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (!$this->endpoint) {
            $io->error('DYNAMODB_ENDPOINT is not set; this command only targets DynamoDB Local.');

            return Command::FAILURE;
        }

        try {
            $this->client->describeTable(['TableName' => $this->tableName]);
            $io->success("Table \"{$this->tableName}\" already exists, nothing to do.");

            return Command::SUCCESS;
        } catch (DynamoDbException $e) {
            if ('ResourceNotFoundException' !== $e->getAwsErrorCode()) {
                throw $e;
            }
        }

        $this->client->createTable([
            'TableName' => $this->tableName,
            'AttributeDefinitions' => [
                ['AttributeName' => 'id', 'AttributeType' => 'S'],
            ],
            'KeySchema' => [
                ['AttributeName' => 'id', 'KeyType' => 'HASH'],
            ],
            'BillingMode' => 'PAY_PER_REQUEST',
        ]);

        $this->client->waitUntil('TableExists', ['TableName' => $this->tableName]);

        $io->success("Table \"{$this->tableName}\" created.");

        return Command::SUCCESS;
    }
}
