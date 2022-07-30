<?php

namespace ChasterApp\RequestBody\SharedLocks;

use ArrayObject;
use ChasterApp\Interfaces\RequestBody\SharedLocks\CreateSharedLockInterface;
use DateTime;

/**
 * Body structure for the create shared lock request
 * @link https://api.chaster.app/api/#/Shared%20Locks/SharedLockController_create
 */
class CreateSharedLock extends ArrayObject implements CreateSharedLockInterface
{
    public function setDescription(string $description): CreateSharedLockInterface
    {
        $this->offsetSet('description', $description);
        return $this;
    }

    public function setDisplayRemainingTime(bool $displayRemainingTime): CreateSharedLockInterface
    {
        $this->offsetSet('displayRemainingTime', $displayRemainingTime);
        return $this;
    }

    public function setHideTimeLogs(bool $hideTimeLogs): CreateSharedLockInterface
    {
        $this->offsetSet('hideTimeLogs', $hideTimeLogs);
        return $this;
    }

    public function setIsPublic(bool $isPublic): CreateSharedLockInterface
    {
        $this->offsetSet('isPublic', $isPublic);
        return $this;
    }

    public function setLimitLockTime(bool $limitLockTime): CreateSharedLockInterface
    {
        $this->offsetSet('limitLockTime', $limitLockTime);
        return $this;
    }

    public function setMaxDate(DateTime $maxDate): CreateSharedLockInterface
    {
        $this->offsetSet('maxDate', $maxDate->format('Y-m-d\TH:i:s.u\Z'));
        return $this;
    }

    public function setMaxDuration(int $maxDuration): CreateSharedLockInterface
    {
        $this->offsetSet('maxDuration', $maxDuration);
        return $this;
    }

    public function setMaxLimitDate(DateTime $maxLimitDate): CreateSharedLockInterface
    {
        $this->offsetSet('maxLimitDate', $maxLimitDate->format('Y-m-d\TH:i:s.u\Z'));
        return $this;
    }

    public function setMaxLimitDuration(int $maxLimitDuration): CreateSharedLockInterface
    {
        $this->offsetSet('maxLimitDuration', $maxLimitDuration);
        return $this;
    }

    public function setMaxLockedUsers(int $maxLockedUsers): CreateSharedLockInterface
    {
        $this->offsetSet('maxLockedUsers', $maxLockedUsers);
        return $this;
    }

    public function setMinDate(DateTime $minDate): CreateSharedLockInterface
    {
        $this->offsetSet('minDate', $minDate->format('Y-m-d\TH:i:s.u\Z'));
        return $this;
    }

    public function setMinDuration(int $minDuration): CreateSharedLockInterface
    {
        $this->offsetSet('minDuration', $minDuration);
        return $this;
    }

    public function setName(string $name): CreateSharedLockInterface
    {
        $this->offsetSet('name', $name);
        return $this;
    }

    public function setPassword(string $password): CreateSharedLockInterface
    {
        $this->offsetSet('password', $password);
        return $this;
    }

    public function setPhotoId(string $photoId): CreateSharedLockInterface
    {
        $this->offsetSet('photoId', $photoId);
        return $this;
    }

    public function setRequireContact(bool $requireContact): CreateSharedLockInterface
    {
        $this->offsetSet('requireContact', $requireContact);
        return $this;
    }
}
