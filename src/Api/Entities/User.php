<?php

namespace Fastik1\Vkfast\Api\Entities;

use Fastik1\Vkfast\Api\VkApi;

class User extends BaseEntity
{
    private VkApi $api;
    private int $user_id;
    private ?array $last_data_users_get = null;

    public function __construct(VkApi $api, $user_id)
    {
        $this->api = $api;
        $this->user_id = $user_id;
    }

    public function mention(?string $text = null): string
    {
        return "@id{$this->user_id}" . (!is_null($text) ? "($text)" : null);
    }

    public function mentionWithFullName(string $name_case = 'nom'): string
    {
        $users_get = $this->getUsersGet($name_case);

        return "{$this->mention("{$users_get->first_name} {$users_get->last_name}")}";
    }

    public function mentionWithFirstName(string $name_case = 'nom'): string
    {
        $users_get = $this->getUsersGet($name_case);

        return "{$this->mention("{$users_get->first_name}")}";
    }

    public function mentionWithLastName(string $name_case = 'nom'): string
    {
        $users_get = $this->getUsersGet($name_case);

        return "{$this->mention("{$users_get->last_name}")}";
    }

    public function isBanned(): bool
    {
        $users_get = $this->getUsersGet();

        if (!isset($users_get->deactivated)) {
            return false;
        }

        return $users_get->deactivated == 'banned';
    }

    public function isDeleted(): bool
    {
        $users_get = $this->getUsersGet();

        if (!isset($users_get->deactivated)) {
            return false;
        }

        return $users_get->deactivated == 'deleted';
    }

    public function isDeactivated(): bool
    {
        return isset($this->getUsersGet()->deactivated);
    }

    public function getUsersGet(string $name_case = 'nom'): object
    {
        if (is_null($this->last_data_users_get)) {
            $this->requestUsersGet($name_case);
        } else {
            if ($this->last_data_users_get['name_case'] != $name_case) {
                $this->requestUsersGet($name_case);
            }
        }

        return $this->last_data_users_get['request']->response[0];
    }

    private function requestUsersGet(string $name_case = 'nom'): object
    {
        $this->last_data_users_get['name_case'] = $name_case;
        $this->last_data_users_get['request'] = $this->api->users->get(user_ids: $this->user_id, name_case: $name_case);

        return $this->last_data_users_get['request'];
    }

    public function refresh(string $name_case = 'nom'): self
    {
        $this->requestUsersGet($name_case);

        return $this;
    }
}