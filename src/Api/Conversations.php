<?php

namespace ChasterApp\Api;

use ChasterApp\ClientOptions;
use ChasterApp\Data\Enum\ConversationsStatus;
use ChasterApp\Exception\InvalidArgumentChasterException;
use ChasterApp\Exception\JsonChasterException;
use ChasterApp\Exception\RequestChasterException;
use ChasterApp\Exception\ResponseChasterException;
use ChasterApp\Interfaces\Api\ConversationsInterface;
use ChasterApp\Interfaces\ResponseInterface;
use ChasterApp\Request;
use DateTime;

class Conversations extends Request implements ConversationsInterface
{
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
     * @return ResponseInterface
     *
     * @throws RequestChasterException
     * @throws ResponseChasterException
     * @throws JsonChasterException
     */
    public function get(
        int $limit = 50,
        ConversationsStatus $status = ConversationsStatus::approved,
        DateTime|string $offset = ''
    ): ResponseInterface {
        if (!empty($offset)) {
            $offset = match (true) {
                is_string($offset) => $offset,
                $offset instanceof DateTime => $offset->format('Y-m-d\TH:i:s.v\Z')
            };
        }
        $options = new ClientOptions(query: [
            'limit' => $limit,
            'status' => $status,
            'offset' => $offset,
        ]);
        $this->getClient('', options: $options);
        return $this->response(200);
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
     * @return ResponseInterface
     *
     * @throws InvalidArgumentChasterException
     * @throws RequestChasterException
     * @throws ResponseChasterException
     * @throws JsonChasterException
     */
    public function create(array $body): ResponseInterface
    {
        $this->checkMandatoryArgument($body, 'Body');
        $options = new ClientOptions(json: $body);
        $this->postClient('', options: $options);
        return $this->response(201);
    }

    /**
     * Find conversation by user id
     * @link https://api.chaster.app/api/#/Messaging/MessagingController_getConversationByUserId
     *
     * @param string $userId Mandatory user ID
     *
     * @return ResponseInterface
     *
     * @throws RequestChasterException
     * @throws InvalidArgumentChasterException
     * @throws ResponseChasterException
     * @throws JsonChasterException
     */
    public function byUser(string $userId): ResponseInterface
    {
        $this->checkMandatoryArgument($userId, 'User ID');
        $this->getClient('by-user/' . $userId);
        return $this->response(200);
    }

    /**
     * Add a new message in a conversation
     * Updates a conversation
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
     * @return ResponseInterface
     *
     * @throws InvalidArgumentChasterException
     * @throws RequestChasterException
     * @throws ResponseChasterException
     * @throws JsonChasterException
     */
    public function send(string $conversationId, array $body): ResponseInterface
    {
        $this->checkMandatoryArgument($conversationId, 'Conversation ID');
        $this->checkMandatoryArgument($body, 'Body');
        $this->postClient($conversationId, options: new ClientOptions(json: $body));
        return $this->response(201);
    }

    /**
     * Find a conversation
     * @link https://api.chaster.app/api/#/Messaging/MessagingController_getConversation
     *
     * @param string $conversationId Mandatory conversation ID
     *
     * @return ResponseInterface
     *
     * @throws InvalidArgumentChasterException
     * @throws RequestChasterException
     * @throws ResponseChasterException
     * @throws JsonChasterException
     */
    public function find(string $conversationId): ResponseInterface
    {
        $this->checkMandatoryArgument($conversationId, 'Conversation ID');
        $this->getClient($conversationId);
        return $this->response(200);
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
     * @throws InvalidArgumentChasterException
     * @throws RequestChasterException
     * @throws ResponseChasterException
     * @throws JsonChasterException
     */
    public function status(string $conversationId, array $body): ResponseInterface
    {
        $this->checkMandatoryArgument($conversationId, 'Conversation ID');
        $this->checkMandatoryArgument($body, 'Body');
        $this->putClient($conversationId . '/status', options: new ClientOptions(json: $body));
        return $this->response(200);
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
     * @throws InvalidArgumentChasterException
     * @throws RequestChasterException
     * @throws ResponseChasterException
     * @throws JsonChasterException
     */
    public function unread(string $conversationId, array $body): ResponseInterface
    {
        $this->checkMandatoryArgument($conversationId, 'Conversation ID');
        $this->checkMandatoryArgument($body, 'Body');
        $this->putClient($conversationId . '/unread', options: new ClientOptions(json: $body));
        return $this->response(200);
    }

    /**
     * Find messages in a conversation
     * @link https://api.chaster.app/api/#/Messaging/MessagingController_getMessages
     *
     * @param string $conversationId Mandatory conversation ID
     * @param int $limit Query limit
     * @param string|null $lastId Last message ID
     *
     * @return ResponseInterface
     *
     * @throws InvalidArgumentChasterException
     * @throws RequestChasterException
     * @throws ResponseChasterException
     * @throws JsonChasterException
     */
    public function messages(string $conversationId, int $limit = 50, ?string $lastId = null): ResponseInterface
    {
        $this->checkMandatoryArgument($conversationId, 'Conversation ID');
        $options = new ClientOptions();
        $options->setQueryValue('limit', $limit);
        if (isset($lastId)) {
            $options->setQueryValue('lastId', $lastId);
        }
        $this->getClient($conversationId . '/messages', options: $options);
        return $this->response(200);
    }

    public function getBaseRoute(): string
    {
        return 'conversations';
    }
}
