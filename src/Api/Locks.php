<?php

namespace ChasterApp\Api;

use ChasterApp\Exception\ChasterInvalidArgumentException;
use DateTime;
use DateTimeZone;

final class Locks extends Request
{
    /**
     * @param string $status optional, values: 'active', 'archived', 'all'
     * @return array|object
     * @throws \ChasterApp\Exception\ChasterInvalidArgumentException
     * @throws \ChasterApp\Exception\ChasterJsonException
     * @throws \ChasterApp\Exception\ChasterRequestException
     */
    public function locks(string $status = 'active'): array|object
    {
        $query = match ($status) {
            'active', 'archived', 'all' => ['status' => $status],
            default => throw new ChasterInvalidArgumentException('Invalid status argument', 400),
        };
        return $this->get('/locks', ['query' => $query]);
    }

    /**
     * @param string $lockId
     * @return array|object
     * @throws \ChasterApp\Exception\ChasterInvalidArgumentException
     * @throws \ChasterApp\Exception\ChasterJsonException
     * @throws \ChasterApp\Exception\ChasterRequestException
     */
    public function lockId(string $lockId): array|object
    {
        if (empty($lockId)) {
            throw new ChasterInvalidArgumentException('The lock id is mandatory', 400);
        }
        return $this->get('/locks/' . addslashes($lockId));
    }

    /**
     * @param string $lockId
     * @return array|object
     * @throws \ChasterApp\Exception\ChasterInvalidArgumentException
     * @throws \ChasterApp\Exception\ChasterJsonException
     * @throws \ChasterApp\Exception\ChasterRequestException
     */
    public function lockArchive(string $lockId): array|object
    {
        if (empty($lockId)) {
            throw new ChasterInvalidArgumentException('The lock id is mandatory', 400);
        }
        return $this->post('/locks/' . addslashes($lockId) . '/archive');
    }

    /**
     * @param string $lockId
     * @return array|object
     * @throws \ChasterApp\Exception\ChasterInvalidArgumentException
     * @throws \ChasterApp\Exception\ChasterJsonException
     * @throws \ChasterApp\Exception\ChasterRequestException
     */
    public function lockArchiveKeyholder(string $lockId): array|object
    {
        if (empty($lockId)) {
            throw new ChasterInvalidArgumentException('The lock id is mandatory', 400);
        }
        return $this->post('/locks/' . addslashes($lockId) . '/archive/keyholder');
    }

    /**
     * @param string $lockId
     * @param int|float $duration
     * @return array|object
     * @throws \ChasterApp\Exception\ChasterInvalidArgumentException
     * @throws \ChasterApp\Exception\ChasterJsonException
     * @throws \ChasterApp\Exception\ChasterRequestException
     */
    public function lockUpdateTime(string $lockId, int|float $duration): array|object
    {
        if (empty($lockId)) {
            throw new ChasterInvalidArgumentException('The lock id is mandatory', 400);
        }

        if (!is_numeric($duration)) {
            throw new ChasterInvalidArgumentException('Duration must be a numeric', 400);
        }
        $json = ['duration' => $duration];
        return $this->post('/locks/' . addslashes($lockId) . '/update-time', $json);
    }

    /**
     * @param string $lockId
     * @param bool $isFrozen
     * @return array|object
     * @throws \ChasterApp\Exception\ChasterInvalidArgumentException
     * @throws \ChasterApp\Exception\ChasterJsonException
     * @throws \ChasterApp\Exception\ChasterRequestException
     */
    public function lockFreeze(string $lockId, bool $isFrozen): array|object
    {
        if (empty($lockId)) {
            throw new ChasterInvalidArgumentException('The lock id is mandatory', 400);
        }
        $json = ['isFrozen' => $isFrozen];
        return $this->post('/locks/' . addslashes($lockId) . '/freeze', $json);
    }

    /**
     * @param string $lockId
     * @return array|object check statusCode
     * @throws \ChasterApp\Exception\ChasterInvalidArgumentException
     * @throws \ChasterApp\Exception\ChasterJsonException
     * @throws \ChasterApp\Exception\ChasterRequestException
     */
    public function lockUnlock(string $lockId): array|object
    {
        if (empty($lockId)) {
            throw new ChasterInvalidArgumentException('The lock id is mandatory', 400);
        }
        return $this->post('/locks/' . addslashes($lockId) . '/unlock');
    }

    /**
     * @param string $lockId
     * @return array|object
     * @throws \ChasterApp\Exception\ChasterInvalidArgumentException
     * @throws \ChasterApp\Exception\ChasterJsonException
     * @throws \ChasterApp\Exception\ChasterRequestException
     */
    public function lockSettings(string $lockId, array $settings): array|object
    {
        if (empty($lockId)) {
            throw new ChasterInvalidArgumentException('The lock id is mandatory', 400);
        }
        $required = ['displayRemainingTime'];
        if (!array_keys_exist($required, $settings)) {
            throw new ChasterInvalidArgumentException('Settings are invalid', 400);
        }
        return $this->post('/locks/' . addslashes($lockId) . '/settings', $settings);
    }

    /**
     * @param string $lockId
     * @param \DateTime|null $maxLimitDate
     * @param bool $disableMaxLimitDate
     * @return array|object
     * @throws \ChasterApp\Exception\ChasterInvalidArgumentException
     * @throws \ChasterApp\Exception\ChasterJsonException
     * @throws \ChasterApp\Exception\ChasterRequestException
     */
    public function lockMaxLimitDate(
        string $lockId,
        ?DateTime $maxLimitDate = null,
        bool $disableMaxLimitDate = false
    ): array|object
    {
        if (empty($lockId)) {
            throw new ChasterInvalidArgumentException('The lock id is mandatory', 400);
        }
        if ($maxLimitDate === null && !$disableMaxLimitDate) {
            throw new ChasterInvalidArgumentException('Max limit date is mandatory if max limit date is active', 400);
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
        return $this->post('/locks/' . addslashes($lockId) . '/max-limit-date', $json);
    }

    /**
     * @param string $lockId
     * @return array|object
     * @throws \ChasterApp\Exception\ChasterInvalidArgumentException
     * @throws \ChasterApp\Exception\ChasterJsonException
     * @throws \ChasterApp\Exception\ChasterRequestException
     */
    public function lockTrustKeyholder(string $lockId): array|object
    {
        if (empty($lockId)) {
            throw new ChasterInvalidArgumentException('The lock id is mandatory', 400);
        }
        return $this->post('/locks/' . addslashes($lockId) . '/trust-keyholder');
    }

    /**
     * @param string $lockId
     * @return array|object
     * @throws \ChasterApp\Exception\ChasterInvalidArgumentException
     * @throws \ChasterApp\Exception\ChasterJsonException
     * @throws \ChasterApp\Exception\ChasterRequestException
     */
    public function lockCombination(string $lockId): array|object
    {
        if (empty($lockId)) {
            throw new ChasterInvalidArgumentException('The lock id is mandatory', 400);
        }
        return $this->get('/locks/' . addslashes($lockId) . '/trust-keyholder');
    }
}