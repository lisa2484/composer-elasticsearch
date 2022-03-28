<?php

namespace Phptycoon\Elk;

use Phptycoon\Elk\Query\Query;
use stdClass;

/**
 * php ver 7.3.33
 * Elasticsearch ver 7.10
 */
class Elasticsearch
{
    protected $url = '';
    protected $search = [];
    protected $body = [];
    protected $index = '';
    protected $path = '';
    protected $size = 30;
    protected $from = 0;

    public function __construct(string $host, string $path = '_search', int $port = 9200, string $protocol = 'http')
    {
        $this->url = $protocol . '://' . $host . ':' . $port;
        $this->path = $path;
    }

    /**
     * 設置查詢.
     * 同類型查詢會被覆蓋,請用其他查詢包裝
     */
    public function setQuery(Query $query): Elasticsearch
    {
        $this->search[$query->queryType()] = $query->generateQuery();
        return $this;
    }

    /**
     * 設置 _source 回傳筆數
     */
    public function setSize(int $size): Elasticsearch
    {
        $this->size = $size;
        return $this;
    }

    /**
     * 設置 _source 跳過筆數
     */
    public function setFrom(int $from): Elasticsearch
    {
        $this->from = $from;
        return $this;
    }

    /**
     * 設置index
     */
    public function setIndex(string $index): Elasticsearch
    {
        $this->index = '/' . $index;
        return $this;
    }

    /**
     * 設置排序
     */
    public function setSort(string $field, bool $desc = true): Elasticsearch
    {
        $this->body['sort'][$field]['order'] = $desc ? 'desc' : 'asc';
        return $this;
    }

    /**
     * 設置是否顯示 _source
     */
    public function source(bool $source): Elasticsearch
    {
        $this->body['_source'] = $source;
        return $this;
    }

    /**
     * 回傳組合查詢json字串
     */
    public function queryString(): string
    {
        $body = $this->body;
        $body['size'] = $this->size;
        $body['from'] = $this->from;
        $body['query'] = empty($this->search) ? ['match_all' => new stdClass] : $this->search;
        $json = json_encode($body);
        return $json ? $json : '';
    }

    /**
     * 發送查詢
     */
    public function search(): string
    {
        $param = $this->queryString();
        $ch = curl_init($this->url . $this->index . '/' . $this->path);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $result = curl_exec($ch);
        return $result ? $result : '';
    }
}
