<?php

namespace ChasterApp\Api;

use ChasterApp\Exception\ChasterInvalidArgumentException;
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
     * @throws \ChasterApp\Exception\ChasterInvalidArgumentException
     * @throws \ChasterApp\Exception\ChasterJsonException
     * @throws \ChasterApp\Exception\ChasterRequestException
     */
    public function locksSearch(
        LockStatus $status,
        string $search = '',
        int $page = 0,
        ?int $limit = null,
        ?Criteria $criteria = null
    ): array|object {
        if (is_int($limit) && $page <= 0) {
            throw new ChasterInvalidArgumentException('Page must not be less than 0', 400);
        }
        if (is_int($limit) && $limit <= 0) {
            throw new ChasterInvalidArgumentException('Limit must not be less than 1', 400);
        }

        $json = [
            'criteria' => isset($criteria) ? $criteria->criteria() : [],
            'status' => $status->value,
            'search' => $search,
            'page' => $page,
            'limit' => $limit
        ];
        return $this->post('/keyholder/locks/search', $json);
    }
}