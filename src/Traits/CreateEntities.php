<?php


namespace Fastik1\Vkfast\Traits;


use Fastik1\Vkfast\Api\Entities\User;

trait CreateEntities
{
    public function user(int $user_id): User
    {
        return new User($this, $user_id);
    }
}