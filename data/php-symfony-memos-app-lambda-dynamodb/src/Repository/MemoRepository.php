<?php

namespace App\Repository;

use App\Entity\Memo;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Symfony\Component\Clock\DatePoint;
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
            'Key' => $this->marshalKey($id),
        ]);
        $item = $result->get('Item');
        if ($item === null) {
            return null;
        }
        return $this->hydrate($this->marshaler->unmarshalItem($item));
    }

    /**
     * @return Memo[]
     */
    public function findLatest(?string $keyword = null): array
    {
        $keyword = trim($keyword ?? '');
        if ($keyword === '') {
            $params = [
                'TableName' => $this->tableName,
                'KeyConditionExpression' => 'pk = :pk',
                'ScanIndexForward' => false,
                'ExpressionAttributeValues' => $this->marshaler->marshalItem([
                    ':pk' => 'MEMO',
                ]),
            ];
        } else {
            // キーワード検索
            $params = [
                'TableName' => $this->tableName,
                'KeyConditionExpression' => 'pk = :pk',
                'ScanIndexForward' => false,
                'FilterExpression' => 'contains(title, :keyword) OR contains(description, :keyword)',
                'ExpressionAttributeValues' => $this->marshaler->marshalItem([
                    ':pk' => 'MEMO',
                    ':keyword' => $keyword,
                ]),
            ];
        }

        $results = $this->client->getPaginator('Query', $params);
        $memos = [];
        foreach ($results as $result) {
            foreach ($result->get('Items') as $item) {
                $memos[] = $this->hydrate($this->marshaler->unmarshalItem($item));
            }
        }
        return $memos;
    }

    public function save(Memo $memo): void
    {
        $now = new DatePoint();

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
            'Key' => $this->marshalKey($memo->getId()),
        ]);
    }

    protected function marshalKey(string $id): array
    {
        return $this->marshaler->marshalItem(['pk' => 'MEMO', 'sk' => $id]);
    }

    /**
     * @param array{id: string, title: string, description: string, created_at: string, updated_at: string} $item
     */
    protected function hydrate(array $item): Memo
    {
        return (new Memo())
            ->setId($item['id'])
            ->setTitle($item['title'])
            ->setDescription($item['description'])
            ->setCreatedAt(new DatePoint($item['created_at']))
            ->setUpdatedAt(new DatePoint($item['updated_at']));
    }
}
