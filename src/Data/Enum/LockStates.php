<?php

namespace ChasterApp\Data\Enum;

enum LockStates: string
{
    case locked = 'locked';
    case unlocked = 'unlocked';
    case deserted = 'deserted';
    case archived = 'archived';
}