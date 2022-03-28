<?php

namespace Phptycoon\Elk\Query;

/**
 * Range query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/7.10/query-dsl-range-query.html
 */
class RangeQuery extends Query
{
    private $field = '';
    private $query = [];

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    public static function init(string $field): RangeQuery
    {
        return new static($field);
    }

    /**
     * 大於
     */
    public function gt(string $gt): RangeQuery
    {
        $this->query[$this->field]['gt'] = $gt;
        return $this;
    }

    /**
     * 大於等於
     */
    public function gte(string $gte): RangeQuery
    {
        $this->query[$this->field]['gte'] = $gte;
        return $this;
    }

    /**
     * 小於
     */
    public function lt(string $lt): RangeQuery
    {
        $this->query[$this->field]['lt'] = $lt;
        return $this;
    }

    /**
     * 小於等於
     */
    public function lte(string $lte): RangeQuery
    {
        $this->query[$this->field]['lte'] = $lte;
        return $this;
    }

    /**
     * 日期格式
     * @link https://www.elastic.co/guide/en/elasticsearch/reference/7.10/mapping-date-format.html#mapping-date-format
     * @param string $format 日期格式
     */
    public function format(string $format): RangeQuery
    {
        $this->query[$this->field]['format'] = $format;
        return $this;
    }

    /**
     * 搜尋模式
     * @param string $relation 搜尋模式, 預設為 INTERSECTS
     */
    public function relation(string $relation = 'INTERSECTS'): RangeQuery
    {
        $this->query[$this->field]['relation'] = $relation;
        return $this;
    }

    /**
     * 設定時區
     * @link https://en.wikipedia.org/wiki/List_of_UTC_time_offsets
     * @link https://en.wikipedia.org/wiki/List_of_tz_database_time_zones
     * @param string $timeZone 時區字串
     */
    public function timeZone(string $timeZone): RangeQuery
    {
        $this->query[$this->field]['time_zone'] = $timeZone;
        return $this;
    }

    /**
     * 設定搜尋relevance score(相關性分數)
     * @param float $boost 搜尋分數, 0 到 1.0, 預設為1.0
     */
    public function boost(float $boost = 1): RangeQuery
    {
        $this->query[$this->field]['boost'] = $boost;
        return $this;
    }

    public function generateQuery(): array
    {
        return $this->query;
    }

    public function queryType(): string
    {
        return 'range';
    }
}
