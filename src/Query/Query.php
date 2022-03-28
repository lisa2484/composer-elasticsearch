<?php

namespace Phptycoon\Elk\Query;

abstract class Query
{
    /**
     * 查詢條件陣列
     */
    abstract public function generateQuery(): array;

    /**
     * 查詢類型名稱
     */
    abstract public function queryType(): string;
}
