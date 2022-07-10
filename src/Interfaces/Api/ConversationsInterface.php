<?php

namespace ChasterApp\Interfaces\Api;

use ChasterApp\Data\Enum\ConversationsStatus;
use ChasterApp\Interfaces\ResponseInterface;
use DateTime;

interface ConversationsInterface
{
    public function get(
        int $limit = 50,
        ConversationsStatus $status = ConversationsStatus::approved,
        string|DateTime $offset = ''
    ): ResponseInterface;
    public function create(array $body): ResponseInterface;
    public function byUser(string $userId): ResponseInterface;
    public function send(string $conversationId, array $body): ResponseInterface;
    public function find(string $conversationId): ResponseInterface;
    public function status(string $conversationId, array $body): ResponseInterface;
    public function unread(string $conversationId, array $body): ResponseInterface;
    public function messages(string $conversationId, int $limit = 50, ?string $lastId = null): ResponseInterface;
}
