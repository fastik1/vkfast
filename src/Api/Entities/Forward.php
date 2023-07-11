<?php

namespace Fastik1\Vkfast\Api\Entities;

use Fastik1\Vkfast\Api\VkApi;

class Forward extends BaseEntity
{
    private int $peer_id;
    private bool $is_reply;
    private ?int $owner_id;
    private array $conversation_message_ids = [];
    private array $message_ids = [];

    public function __construct(int $peer_id, bool $is_reply = false, ?int $owner_id = null)
    {
        $this->peer_id = $peer_id;
        $this->is_reply = $is_reply;
        $this->owner_id = $owner_id;
    }

    public function addConversationMessageId(int|array $id): self
    {
        $this->pushItemOrItemsToArray($this->conversation_message_ids, $id);
        return $this;
    }

    public function addMessageId(int|array $id): self
    {
        $this->pushItemOrItemsToArray($this->message_ids, $id);
        return $this;
    }

    public function json(): string
    {
        $forward = [
            "is_reply" => $this->is_reply,
            "peer_id" => $this->peer_id,
        ];

        if (!empty($this->conversation_message_ids)) {
            $forward['conversation_message_ids'] = $this->conversation_message_ids;
        } else if (!empty($this->message_ids)) {
            $forward['message_ids'] = $this->message_ids;
        }

        return json_encode($forward);
    }

    private function pushItemOrItemsToArray(array &$array, mixed $needle): array
    {
        if (is_array($needle)) {
            foreach ($needle as $item) {
                $array[] = $item;
            }
        } else {
            $array[] = $needle;
        }

        return $array;
    }
}