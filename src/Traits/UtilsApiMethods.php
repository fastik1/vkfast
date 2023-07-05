<?php


namespace Fastik1\Vkfast\Traits;


trait UtilsApiMethods
{
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
