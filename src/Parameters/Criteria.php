<?php

namespace ChasterApp\Parameters;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Criteria
{
    private array $sharedLocks;

    /**
     * @return array
     */
    #[Pure] #[ArrayShape(['sharedLocks' => "array"])] public function criteria(): array
    {
        return [
            'sharedLocks' => [
                $this->getSharedLocks(),
            ],
        ];
    }

    /**
     * @return array
     */
    public function getSharedLocks(): array
    {
        return $this->sharedLocks;
    }

    /**
     * @param array $sharedLockIds
     * @param bool $includeKeyholderLocks
     */
    public function setSharedLocks(array $sharedLockIds = [], bool $includeKeyholderLocks = true): void
    {
        $this->sharedLocks = [
            'sharedLockIds' => $sharedLockIds,
            'includeKeyholderLocks' => $includeKeyholderLocks,
        ];
    }

}