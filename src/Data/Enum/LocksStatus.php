<?php

namespace ChasterApp\Data\Enum;

/**
 *
 */
enum LocksStatus: string
{
    case active = 'active';
    case archived = 'archived';
    case all = 'all';
}
