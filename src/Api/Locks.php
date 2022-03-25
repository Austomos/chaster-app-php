<?php

namespace ChasterApp\Api;

use ChasterApp\Data\Enum\LocksStatus;
use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Exception\JsonChasterException;
use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Interfaces\Api\LocksInterface;
use ChasterApp\Utils\Utils;
use DateTime;
use DateTimeZone;

final class Locks extends Request implements LocksInterface
{
    use Utils;

    private const LOCKS = '/locks';

    /**
     * Get user locks
     * Returns a list of all user locks
     * By default, only active locks are returned.
     * @link https://api.chaster.app/api/#/Locks/LockController_findAll
     *
     * @param LocksStatus $status   The lock status
     *                              Available values : active, archived, all
     *                              Default value : active
     *
     * @return object
     *
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function get(LocksStatus $status = LocksStatus::active): object
    {
        return $this->getClient(self::LOCKS, ['status' => $status->name]);
    }

    /**
     * Update lock duration
     * Adds or removes duration to a lock. Keyholders can add or remove time, while wearers can only add time.
     * @link https://api.chaster.app/api/#/Locks/LockController_updateTime
     *
     * @param string $lockId Mandatory. The lock id
     * @param array $body Mandatory. Array containing the body parameters
     *
     *      {
     *          'duration': 0
     *      }
     *
     * @throws InvalidArgumentChasterException
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function updateTime(string $lockId, array $body): void
    {
        $this->checkMandatory($lockId, 'Lock ID');
        $this->checkMandatory($body, 'Body');
        $this->postClient(self::LOCKS . '/' . $lockId . '/update-time', $body);
    }

    /**
     * Freeze a lock
     * Freezes a lock. Keyholders can use this endpoint to freeze wearer's locks.
     * @link https://api.chaster.app/api/#/Locks/LockController_setFreeze
     *
     * @param string $lockId Mandatory. The lock id
     * @param array $body Mandatory. Array containing the body parameters
     *
     *      {
     *          'isFrozen': true
     *      }
     *
     * @throws InvalidArgumentChasterException
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function freeze(string $lockId, array $body): void
    {
        $this->checkMandatory($lockId, 'Lock ID');
        $this->checkMandatory($body, 'Body');
        $this->postClient(self::LOCKS . '/' . $lockId . '/freeze', $body);
    }

    /**
     * @param string $status optional, values: 'active', 'archived', 'all'
     * @return array|object
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function locks(string $status = 'active'): array|object
    {
        $query = match ($status) {
            'active', 'archived', 'all' => ['status' => $status],
            default => throw new InvalidArgumentChasterException('Invalid status argument', 400),
        };
        return $this->getClient('/locks', ['query' => $query]);
    }

    /**
     * @param string $lockId
     * @return array|object
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function lockId(string $lockId): array|object
    {
        if (empty($lockId)) {
            throw new InvalidArgumentChasterException('The lock id is mandatory', 400);
        }
        return $this->getClient('/locks/' . addslashes($lockId));
    }

    /**
     * @param string $lockId
     * @return array|object
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function lockArchive(string $lockId): array|object
    {
        if (empty($lockId)) {
            throw new InvalidArgumentChasterException('The lock id is mandatory', 400);
        }
        return $this->postClient('/locks/' . addslashes($lockId) . '/archive');
    }

    /**
     * @param string $lockId
     * @return array|object
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function lockArchiveKeyholder(string $lockId): array|object
    {
        if (empty($lockId)) {
            throw new InvalidArgumentChasterException('The lock id is mandatory', 400);
        }
        return $this->postClient('/locks/' . addslashes($lockId) . '/archive/keyholder');
    }

    /**
     * @param string $lockId
     * @param int|float $duration
     * @return array|object
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function lockUpdateTime(string $lockId, int|float $duration): array|object
    {
        if (empty($lockId)) {
            throw new InvalidArgumentChasterException('The lock id is mandatory', 400);
        }

        if (!is_numeric($duration)) {
            throw new InvalidArgumentChasterException('Duration must be a numeric', 400);
        }
        $json = ['duration' => $duration];
        return $this->postClient('/locks/' . addslashes($lockId) . '/update-time', $json);
    }

    /**
     * @param string $lockId
     * @param bool $isFrozen
     * @return array|object
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function lockFreeze(string $lockId, bool $isFrozen): array|object
    {
        if (empty($lockId)) {
            throw new InvalidArgumentChasterException('The lock id is mandatory', 400);
        }
        $json = ['isFrozen' => $isFrozen];
        return $this->postClient('/locks/' . addslashes($lockId) . '/freeze', $json);
    }

    /**
     * @param string $lockId
     * @return array|object check statusCode
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function lockUnlock(string $lockId): array|object
    {
        if (empty($lockId)) {
            throw new InvalidArgumentChasterException('The lock id is mandatory', 400);
        }
        return $this->postClient('/locks/' . addslashes($lockId) . '/unlock');
    }

    /**
     * @param string $lockId
     * @return array|object
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function lockSettings(string $lockId, array $settings): array|object
    {
        if (empty($lockId)) {
            throw new InvalidArgumentChasterException('The lock id is mandatory', 400);
        }
        $required = ['displayRemainingTime'];
        if (!$this->arrayKeysExist($required, $settings)) {
            throw new InvalidArgumentChasterException('Settings are invalid', 400);
        }
        return $this->postClient('/locks/' . addslashes($lockId) . '/settings', $settings);
    }

    /**
     * @param string $lockId
     * @param \DateTime|null $maxLimitDate
     * @param bool $disableMaxLimitDate
     * @return array|object
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function lockMaxLimitDate(
        string $lockId,
        ?DateTime $maxLimitDate = null,
        bool $disableMaxLimitDate = false
    ): array|object
    {
        if (empty($lockId)) {
            throw new InvalidArgumentChasterException('The lock id is mandatory', 400);
        }
        if ($maxLimitDate === null && !$disableMaxLimitDate) {
            throw new InvalidArgumentChasterException('Max limit date is mandatory if max limit date is active', 400);
        }
        if ($maxLimitDate === null && $disableMaxLimitDate) {
            $given = new DateTime('2014-12-12 14:18:00');
            echo $given->format('Y-m-d H:i:s e') . "\n"; // 2014-12-12 14:18:00 Asia/Bangkok

            echo $given->format('Y-m-d H:i:s e') . "\n"; // 2014-12-12 07:18:00 UTC
            $maxLimitDate = new DateTime('2400-12-31 23:59:59.999');
        }
        $maxLimitDate->setTimezone(new DateTimeZone('UTC'));
        $json = [
            'maxLimitDate' => $maxLimitDate->format('Y-m-d\TH:i:s.v\Z'),
            'disableMaxLimitDate' => $disableMaxLimitDate,
        ];
        return $this->postClient('/locks/' . addslashes($lockId) . '/max-limit-date', $json);
    }

    /**
     * @param string $lockId
     * @return array|object
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function lockTrustKeyholder(string $lockId): array|object
    {
        if (empty($lockId)) {
            throw new InvalidArgumentChasterException('The lock id is mandatory', 400);
        }
        return $this->postClient('/locks/' . addslashes($lockId) . '/trust-keyholder');
    }

    /**
     * @param string $lockId
     * @return array|object
     * @throws \ChasterApp\Exception\InvalidArgumentChasterException
     * @throws \ChasterApp\Exception\JsonChasterException
     * @throws \ChasterApp\Exception\RequestChasterException
     */
    public function lockCombination(string $lockId): array|object
    {
        if (empty($lockId)) {
            throw new InvalidArgumentChasterException('The lock id is mandatory', 400);
        }
        return $this->getClient('/locks/' . addslashes($lockId) . '/trust-keyholder');
    }

}