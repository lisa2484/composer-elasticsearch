<?php

namespace Phptycoon\Elk\Query;

/**
 * Boolean query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/7.10/query-dsl-bool-query.html
 */
class BoolQuery extends Query
{
    private $datas = [];

    public static function init(): BoolQuery
    {
        return new static;
    }
    /**
     * The clause (query) must appear in matching documents and will contribute to the score.
     */
    public function must(Query $query): BoolQuery
    {
        $this->datas['must'][] = [$query->queryType() => $query->generateQuery()];
        return $this;
    }

    /**
     * The clause (query) must appear in matching documents. However unlike must the score of the query will be ignored. Filter clauses are executed in filter context, meaning that scoring is ignored and clauses are considered for caching.
     */
    public function filter(Query $query): BoolQuery
    {
        $this->datas['filter'][] = [$query->queryType() => $query->generateQuery()];
        return $this;
    }

    /**
     * The clause (query) should appear in the matching document.
     */
    public function should(Query $query): BoolQuery
    {
        $this->datas['must_not'][] = [$query->queryType() => $query->generateQuery()];
        return $this;
    }

    /**
     * The clause (query) must not appear in the matching documents. Clauses are executed in filter context meaning that scoring is ignored and clauses are considered for caching. Because scoring is ignored, a score of 0 for all documents is returned.
     */
    public function mustNot(Query $query): BoolQuery
    {
        $this->datas['must_not'][] = [$query->queryType() => $query->generateQuery()];
        return $this;
    }
    /**
     * You can use the minimum_should_match parameter to specify the number or percentage of should clauses returned documents must match.
     * If the bool query includes at least one should clause and no must or filter clauses, the default value is 1. Otherwise, the default value is 0.
     */
    public function minimumShouldMatch(int $value): BoolQuery
    {
        $this->datas['minimum_should_match'] = $value;
        return $this;
    }

    public function boost(float $boost = 1): BoolQuery
    {
        $this->datas['boost'] = $boost;
        return $this;
    }

    public function generateQuery(): array
    {
        return $this->datas;
    }

    public function queryType(): string
    {
        return 'bool';
    }
}
