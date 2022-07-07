<?php

namespace ChasterApp\Data\Enum;

enum ConversationsStatus: string
{
    case pending = 'pending';
    case approved = 'approved';
    case ignored = 'ignored';
}
