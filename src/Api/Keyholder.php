<?php

namespace ChasterApp\Api;

use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Parameters\{
    LockStatus,
    Criteria
};

final class Keyholder extends Request
{

    /**
     * @param \ChasterApp\Parameters\LockStatus $status
     * @param string $search
     * @param int $page
     * @param int|null $limit
     * @param \ChasterApp\Parameters\Criteria|null $criteria
     * @return array|object
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function locksSearch(
        LockStatus $status,
        string $search = '',
        int $page = 0,
        ?int $limit = null,
        ?Criteria $criteria = null
    ): array|object {
        if (is_int($limit) && $page <= 0) {
            throw new InvalidArgumentChasterException('Page must not be less than 0', 400);
        }
        if (is_int($limit) && $limit <= 0) {
            throw new InvalidArgumentChasterException('Limit must not be less than 1', 400);
        }

        $json = [
            'criteria' => isset($criteria) ? $criteria->criteria() : [],
            'status' => $status->value,
            'search' => $search,
            'page' => $page,
            'limit' => $limit
        ];
        return $this->postClient('/keyholder/locks/search', $json);
    }
}