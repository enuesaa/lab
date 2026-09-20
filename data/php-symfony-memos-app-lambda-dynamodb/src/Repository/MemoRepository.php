<?php

namespace App\Repository;

use App\Entity\Memo;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Symfony\Component\Uid\Uuid;

class MemoRepository
{
    public function __construct(
        private readonly DynamoDbClient $client,
        private readonly Marshaler $marshaler,
        private readonly string $tableName,
    ) {
    }

    public function find(string $id): ?Memo
    {
        $result = $this->client->getItem([
            'TableName' => $this->tableName,
            'Key' => $this->marshaler->marshalItem(['id' => $id]),
        ]);

        $item = $result->get('Item');

        return $item ? $this->hydrate($this->marshaler->unmarshalItem($item)) : null;
    }

    /**
     * @return Memo[]
     */
    public function findAllOrderedByCreatedAtDesc(): array
    {
        $memos = [];
        $params = ['TableName' => $this->tableName];

        do {
            $result = $this->client->scan($params);

            foreach ($result->get('Items') as $item) {
                $memos[] = $this->hydrate($this->marshaler->unmarshalItem($item));
            }

            $params['ExclusiveStartKey'] = $result->get('LastEvaluatedKey');
        } while ($params['ExclusiveStartKey']);

        usort($memos, static fn (Memo $a, Memo $b) => $b->getCreatedAt() <=> $a->getCreatedAt());

        return $memos;
    }

    public function save(Memo $memo): void
    {
        $now = new \DateTimeImmutable();

        if (null === $memo->getId()) {
            $memo->setId(Uuid::v7()->toRfc4122());
            $memo->setCreatedAt($now);
        }

        $memo->setUpdatedAt($now);

        $this->client->putItem([
            'TableName' => $this->tableName,
            'Item' => $this->marshaler->marshalItem([
                'id' => $memo->getId(),
                'title' => $memo->getTitle(),
                'description' => $memo->getDescription(),
                'created_at' => $memo->getCreatedAt()->format(\DATE_ATOM),
                'updated_at' => $memo->getUpdatedAt()->format(\DATE_ATOM),
            ]),
        ]);
    }

    public function remove(Memo $memo): void
    {
        $this->client->deleteItem([
            'TableName' => $this->tableName,
            'Key' => $this->marshaler->marshalItem(['id' => $memo->getId()]),
        ]);
    }

    /**
     * @param array{id: string, title: string, description: string, created_at: string, updated_at: string} $item
     */
    private function hydrate(array $item): Memo
    {
        return (new Memo())
            ->setId($item['id'])
            ->setTitle($item['title'])
            ->setDescription($item['description'])
            ->setCreatedAt(new \DateTimeImmutable($item['created_at']))
            ->setUpdatedAt(new \DateTimeImmutable($item['updated_at']));
    }
}
