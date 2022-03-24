<?php

namespace ChasterApp\Interfaces\Api;

use ChasterApp\Data\Enum\ConversationsStatus;
use DateTime;

interface ConversationsInterface
{
    public function get(int $limit = 50, ConversationsStatus $status = ConversationsStatus::approved, ?DateTime $offset = null): object;
    public function create(array $body): object;
    public function byUser(string $userId): object;
    public function send(string $conversationId, array $body): object;
    public function find(string $conversationId): object;
    public function status(string $conversationId, array $body): object;
    public function unread(string $conversationId, array $body): object;
    public function messages(string $conversationId, int $limit = 50, ?string $lastId = null): object;
}