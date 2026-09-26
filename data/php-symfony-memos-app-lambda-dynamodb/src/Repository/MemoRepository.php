<?php

namespace App\Repository;

use App\Entity\Memo;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Symfony\Component\Uid\Uuid;

class MemoRepository
{
    private readonly Marshaler $marshaler;

    public function __construct(
        private readonly DynamoDbClient $client,
        private readonly string $tableName,
    ) {
        $this->marshaler = new Marshaler();
    }

    public function find(string $id): ?Memo
    {
        $result = $this->client->getItem([
            'TableName' => $this->tableName,
            'Key' => $this->key($id),
        ]);

        $item = $result->get('Item');

        return $item ? $this->hydrate($this->marshaler->unmarshalItem($item)) : null;
    }

    /**
     * @return Memo[]
     */
    public function findLatest(?string $keyword = null): array
    {
        $params = [
            'TableName' => $this->tableName,
            'KeyConditionExpression' => 'pk = :pk',
            'ScanIndexForward' => false,
        ];
        $values = [':pk' => 'MEMO'];

        $keyword = trim($keyword ?? '');
        if ($keyword !== '') {
            $params['FilterExpression'] = 'contains(title, :keyword) OR contains(description, :keyword)';
            $values[':keyword'] = $keyword;
        }
        $params['ExpressionAttributeValues'] = $this->marshaler->marshalItem($values);

        $memos = [];
        foreach ($this->client->getPaginator('Query', $params) as $result) {
            foreach ($result->get('Items') as $item) {
                $memos[] = $this->hydrate($this->marshaler->unmarshalItem($item));
            }
        }
        return $memos;
    }

    public function save(Memo $memo): void
    {
        $now = new \DateTimeImmutable();

        if ($memo->getId() === null) {
            $memo->setId(Uuid::v7()->toRfc4122());
            $memo->setCreatedAt($now);
        }
        $memo->setUpdatedAt($now);

        $this->client->putItem([
            'TableName' => $this->tableName,
            'Item' => $this->marshaler->marshalItem([
                'pk' => 'MEMO',
                'sk' => $memo->getId(),
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
            'Key' => $this->key($memo->getId()),
        ]);
    }

    private function key(string $id): array
    {
        return $this->marshaler->marshalItem(['pk' => 'MEMO', 'sk' => $id]);
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
