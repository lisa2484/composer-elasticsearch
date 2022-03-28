<?php

namespace Phptycoon\Elk\Query;

/**
 * Term query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/7.10/query-dsl-term-query.html
 */
class TermQuery extends Query
{
    private $field = '';
    private $query = [];

    public function __construct(string $field, string $value)
    {
        $this->field = $field;
        $this->query[$field]['value'] = $value;
    }

    /**
     * 建立查詢物件並初始化後回傳
     * @param string $field 查詢field
     * @param string $value 查詢條件
     */
    public static function init(string $field, string $value)
    {
        return new static($field, $value);
    }

    /**
     * 設定field,可用在複數條件查詢
     */
    public function field(string $field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * 設定field value,未修改field則修改原field value
     * @param string $value 查詢條件
     */
    public function value(string $value)
    {
        $this->query[$this->field]['value'] = $value;
        return $this;
    }

    /**
     * 設定case_insensitive,該功能為是否進行不區分大小寫搜尋,預設為false
     * @param bool $value 是否不區分大小寫
     */
    public function caseInsensitive(bool $value = false)
    {
        $this->query[$this->field]['case_insensitive'] = $value;
        return $this;
    }

    public function generateQuery(): array
    {
        return $this->query;
    }

    public function queryType(): string
    {
        return 'term';
    }
}
