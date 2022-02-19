<?php

namespace ChasterApp\Parameters;

enum LockStatus: string
{
    case LOCKED = 'locked';
    case UNLOCKED = 'unlocked';
    case DESERTED = 'deserted';
    case ARCHIVED = 'archived';
}