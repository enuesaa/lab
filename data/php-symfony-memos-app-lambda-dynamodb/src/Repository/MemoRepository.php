<?php

namespace App\Repository;

use App\Entity\Memo;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Symfony\Component\Uid\Uuid;

class MemoRepository
{
    private const PARTITION_KEY = 'MEMO';

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

    public function findLatest(int $limit, ?string $cursor = null, ?string $keyword = null): MemoPage
    {
        $keyCondition = 'pk = :pk';
        $values = [':pk' => self::PARTITION_KEY];

        if (null !== $cursor && '' !== $cursor) {
            $keyCondition .= ' AND sk < :cursor';
            $values[':cursor'] = $cursor;
        }

        $params = [
            'TableName' => $this->tableName,
            'KeyConditionExpression' => $keyCondition,
            'ScanIndexForward' => false,
        ];

        $keyword = $this->normalize($keyword ?? '');
        if ('' === $keyword) {
            $params['Limit'] = $limit + 1;
        } else {
            $params['FilterExpression'] = 'contains(search_text, :keyword)';
            $values[':keyword'] = $keyword;
        }

        $params['ExpressionAttributeValues'] = $this->marshaler->marshalItem($values);

        $memos = [];

        do {
            $result = $this->client->query($params);

            foreach ($result->get('Items') as $item) {
                $memos[] = $this->hydrate($this->marshaler->unmarshalItem($item));
            }

            $params['ExclusiveStartKey'] = $result->get('LastEvaluatedKey');
        } while ($params['ExclusiveStartKey'] && \count($memos) <= $limit);

        if (\count($memos) <= $limit) {
            return new MemoPage($memos, null);
        }

        $memos = \array_slice($memos, 0, $limit);

        return new MemoPage($memos, end($memos)->getId());
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
                'pk' => self::PARTITION_KEY,
                'sk' => $memo->getId(),
                'id' => $memo->getId(),
                'title' => $memo->getTitle(),
                'description' => $memo->getDescription(),
                'created_at' => $memo->getCreatedAt()->format(\DATE_ATOM),
                'updated_at' => $memo->getUpdatedAt()->format(\DATE_ATOM),
                'search_text' => $this->normalize($memo->getTitle()."\n".$memo->getDescription()),
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
        return $this->marshaler->marshalItem(['pk' => self::PARTITION_KEY, 'sk' => $id]);
    }

    private function normalize(string $text): string
    {
        return mb_strtolower(trim(\Normalizer::normalize($text, \Normalizer::FORM_KC)));
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
