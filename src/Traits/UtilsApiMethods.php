<?php


namespace Fastik1\Vkfast\Traits;


use CURLFile;
use Fastik1\Vkfast\Api\Keyboard\Keyboard;

trait UtilsApiMethods
{
    public function sendMessage(int|array $peer_ids, string|int $message, ?Keyboard $keyboard = null, bool $mentions = false, ?string $attachment = null, ...$arguments): mixed
    {
        $parameters = [
            'peer_ids' => $peer_ids,
            'message' => $message,
            'disable_mentions' => !$mentions,
            'random_id' => 0,
        ];

        if ($keyboard)
            $parameters['keyboard'] = $keyboard->json();

        if ($attachment)
            $parameters['attachment'] = $attachment;

        return $this->messages->send($parameters + $arguments);
    }

    public function upload(string $url, string $file, string $type = 'photo')
    {
        $file = is_resource($file) ? stream_get_meta_data($file)['uri'] : $file;

        return $this->request->sendCurl([
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [$type => new CURLFile($file)],
        ]);
    }

    public function convertUserId(string|int $value): int|bool
    {
        $regex1 = preg_match('/http[s|]*:\/\/vk\.com\/id([0-9]+)/', $value, $itog1, PREG_OFFSET_CAPTURE);
        $regex2 = preg_match('/http[s|]*:\/\/vk\.com\/(.*)/', $value, $itog2, PREG_OFFSET_CAPTURE);
        $regex3 = preg_match('/\[id([0-9]+)\|(.*)\]/', $value, $itog3, PREG_OFFSET_CAPTURE);

        $id = $this->users->get(user_ids: $value)->response[0]->id ?? null;
        if ($id) {
            return $id;
        } else if ($regex1 == 1 and isset($itog1[1][0])) {
            $id = $this->users->get(user_ids:  $itog1[1][0])?->response[0]->id ?? null;
            if ($id)
                return $id;
        } elseif ($regex2 == 1 and isset($itog2[1][0])) {
            $id = $this->utils->resolveScreenName(screen_name: $itog2[1][0])?->response->object_id ?? null;
            if ($id)
                return $id;
        } elseif ($regex3 == 1 and isset($itog3[1][0])) {
            $id = $this->users->get(user_ids: $itog3[1][0])?->response[0]->id ?? null;
            if ($id)
                return $id;
        }

        return false;
    }

    public function isChatMember(int $user_id, int $peer_id): bool
    {
        $chatMembers = $this->messages->getConversationMembers(peer_id: $peer_id);

        if (!isset($chatMembers->response->items)) {
            return false;
        }

        foreach ($chatMembers->response->items as $item) {
            if ($item->member_id == $user_id) {
                return true;
            }
        }

        return false;
    }

    public function isAdminChat(int $user_id, int $peer_id): bool
    {
        $members = $this->messages->getConversationMembers(peer_id: $peer_id);

        if (!isset($members->response->items))
            return false;

        foreach ($members->response->items as $item) {
            if ($item->member_id == $user_id and $item->is_admin ?? false) {
                return true;
            }
        }

        return false;
    }

    public function getGroupRole(int $user_id, int $group_id): bool|string
    {
        $groupMagagers = $this->groups->getMembers(group_id: $group_id, filter: 'managers');

        if (!isset($groupMagagers->response->items)) {
            return false;
        }

        foreach ($groupMagagers->response->items as $item) {
            if ($item->id == $user_id) {
                return $item->role;
            }
        }

        return false;
    }
}
