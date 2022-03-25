<?php

namespace ChasterApp\Api;

use ChasterApp\Data\Enum\ConversationsStatus;
use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Exception\JsonChasterException;
use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Interfaces\Api\ConversationsInterface;
use DateTime;

final class Conversations extends Request implements ConversationsInterface
{
    private const CONVERSATIONS = '/conversation';

    /**
     * Find a list of conversations
     * @link https://api.chaster.app/api/#/Messaging/MessagingController_getConversations
     *
     * @param int $limit The query limit
     * @param ConversationsStatus $status The conversation status
     * @param DateTime|string $offset
     * UTC DateTime -> format 'Y-m-d\TH:i:s.v\Z'
     * The query offset, date of last message
     * Use the field lastMessageAt for pagination
     *
     * @return object
     *
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function get(
        int $limit = 50,
        ConversationsStatus $status = ConversationsStatus::approved,
        DateTime|string $offset = ''
    ): object {
        $query['limit'] = $limit;
        $query['status'] = $status->name;
        if (isset($offset)) {
            $query['offset'] = match (true) {
                is_string($offset) => $offset,
                $offset instanceof DateTime => $offset->format('Y-m-d\TH:i:s.v\Z')
            };
        }
        return $this->getClient(self::CONVERSATIONS, $query);
    }


    /**
     * Create a conversation
     * @link https://api.chaster.app/api/#/Messaging/MessagingController_createConversation
     *
     * @param array $body Mandatory, array containing the body params
     *  $body = [
     *      'users': [
     *          'string'
     *      ],
     *      'type': 'private',
     *      'attachments': 'string',
     *      'message': 'string',
     *      'nonce': 'string'
     *  ]
     *
     * @return object
     *
     * @throws InvalidArgumentChasterException
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function create(array $body): object
    {
        $this->checkMandatory($body, 'Body');
        return $this->postClient(self::CONVERSATIONS, $body);
    }

    /**
     * Find conversation by user id
     * @link https://api.chaster.app/api/#/Messaging/MessagingController_getConversationByUserId
     *
     * @param string $userId Mandatory user ID
     *
     * @return object
     *
     * @throws JsonChasterException
     * @throws RequestChasterException
     * @throws InvalidArgumentChasterException
     */
    public function byUser(string $userId): object
    {
        $this->checkMandatory($userId, 'User ID');
        return $this->getClient(self::CONVERSATIONS . '/by-user/' . $userId);
    }

    /**
     * Add a new message in a conversation
     * @link https://api.chaster.app/api/#/Messaging/MessagingController_sendMessage
     *
     * @param string $conversationId Mandatory conversation ID
     * @param array $body Mandatory, array containing the body params
     * $body = [
     *      'attachments': 'string',
     *      'message': 'string',
     *      'nonce': 'string'
     * ]
     *
     * @return object
     *
     * @throws InvalidArgumentChasterException
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function send(string $conversationId, array $body): object
    {
        $this->checkMandatory($conversationId, 'Conversation ID');
        $this->checkMandatory($body, 'Body');
        return $this->postClient(self::CONVERSATIONS . '/' . $conversationId, $body);
    }

    /**
     * Find a conversation
     * @link https://api.chaster.app/api/#/Messaging/MessagingController_getConversation
     *
     * @param string $conversationId Mandatory conversation ID
     *
     * @return object
     *
     * @throws InvalidArgumentChasterException
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function find(string $conversationId): object
    {
        $this->checkMandatory($conversationId, 'Conversation ID');
        return $this->getClient(self::CONVERSATIONS . '/' . $conversationId);
    }

    /**
     * Set a conversation status
     * @link https://api.chaster.app/api/#/Messaging/MessagingController_setConversationStatus
     *
     * @param string $conversationId Mandatory conversation ID
     * @param array $body Mandatory, array containing the body params
     * $body = [
     *      'status': 'approved'
     * ]
     *
     * @return object
     *
     * @throws InvalidArgumentChasterException
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function status(string $conversationId, array $body): object
    {
        $this->checkMandatory($conversationId, 'Conversation ID');
        $this->checkMandatory($body, 'Body');
        return $this->putClient(self::CONVERSATIONS . '/' . $conversationId . '/status');
    }

    /**
     * Set a conversation unread status
     * @link https://api.chaster.app/api/#/Messaging/MessagingController_setConversationUnread
     *
     * @param string $conversationId Mandatory conversation ID
     * @param array $body Mandatory, array containing the body params
     * $body = [
     *      'unread': true
     * ]
     *
     * @return object
     *
     * @throws InvalidArgumentChasterException
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function unread(string $conversationId, array $body): object
    {
        $this->checkMandatory($conversationId, 'Conversation ID');
        $this->checkMandatory($body, 'Body');
        return $this->putClient(self::CONVERSATIONS . '/' . $conversationId . '/unread');
    }

    /**
     * Find messages in a conversation
     * @link https://api.chaster.app/api/#/Messaging/MessagingController_getMessages
     *
     * @param string $conversationId Mandatory conversation ID
     * @param int $limit Query limit
     * @param string|null $lastId Last message ID
     *
     * @return object
     *
     * @throws InvalidArgumentChasterException
     * @throws JsonChasterException
     * @throws RequestChasterException
     */
    public function messages(string $conversationId, int $limit = 50, ?string $lastId = null): object
    {
        $this->checkMandatory($conversationId, 'Conversation ID');
        $query['limit'] = $limit;
        if (isset($lastId)) {
            $query['lastId'] = $lastId;
        }
        return $this->getClient(self::CONVERSATIONS . '/' . $conversationId . '/messages', $query);
    }

}