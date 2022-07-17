<?php

namespace ChasterApp\Interfaces\RequestBody;

use DateTime;

interface CreateSharedLockInterface
{
    public function setDescription(string $description): self;

    public function setDisplayRemainingTime(bool $displayRemainingTime): self;

    public function setHideTimeLogs(bool $hideTimeLogs): self;

    public function setIsPublic(bool $isPublic): self;

    public function setLimitLockTime(bool $limitLockTime): self;

    public function setMaxDate(DateTime $maxDate): self;

    public function setMaxDuration(int $maxDuration): self;

    public function setMaxLimitDate(DateTime $maxLimitDate): self;

    public function setMaxLimitDuration(int $maxLimitDuration): self;

    public function setMaxLockedUsers(int $maxLockedUsers): self;

    public function setMinDate(DateTime $minDate): self;

    public function setMinDuration(int $minDuration): self;

    public function setName(string $name): self;

    public function setPassword(string $password): self;

    public function setPhotoId(string $photoId): self;

    public function setRequireContact(bool $requireContact): self;
}
