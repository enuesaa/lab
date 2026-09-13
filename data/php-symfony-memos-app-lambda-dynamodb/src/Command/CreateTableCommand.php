<?php

namespace App\Command;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:dynamodb:create-table', description: 'Creates the DynamoDB table used to store memos (this app\'s stand-in for a migration).')]
class CreateTableCommand extends Command
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
            $io->note(sprintf('Table "%s" already exists, nothing to do.', $this->tableName));

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

        $io->success(sprintf('Table "%s" created.', $this->tableName));

        return Command::SUCCESS;
    }
}
