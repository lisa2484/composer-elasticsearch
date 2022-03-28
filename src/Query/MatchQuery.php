<?php

namespace Phptycoon\Elk\Query;

/**
 * Match query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/7.10/query-dsl-match-query.html
 */
class MatchQuery extends Query
{
    private $field = '';
    private $query = [];

    public function __construct(string $field, string $query)
    {
        $this->field = $field;
        $this->query[$field] = $query;
    }

    public static function init(string $field, string $query): MatchQuery
    {
        return new static($field, $query);
    }

    /**
     * 設置查詢欄位
     */
    public function field(string $field): MatchQuery
    {
        $this->field = $field;
        return $this;
    }

    /**
     * 設置查詢條件
     */
    public function query(string $query): MatchQuery
    {
        $this->query[$this->field] = $query;
        return $this;
    }

    /**
     * field 與 query 的合體功能
     */
    public function fieldQuery(string $field, string $query): MatchQuery
    {
        $this->field = $field;
        $this->query[$field] = $query;
        return $this;
    }

    public function generateQuery(): array
    {
        return $this->query;
    }
    public function queryType(): string
    {
        return 'match';
    }
}
