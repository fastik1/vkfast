<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Api\VkApiRequest;
use Fastik1\Vkfast\Utils;

/**
 * @method add(...$arguments)
 * @method addList(...$arguments)
 * @method areFriends(...$arguments)
 * @method delete(...$arguments)
 * @method deleteAllRequests(...$arguments)
 * @method deleteList(...$arguments)
 * @method edit(...$arguments)
 * @method editList(...$arguments)
 * @method get(...$arguments)
 * @method getAppUsers(...$arguments)
 * @method getAvailableForCall(...$arguments)
 * @method getByPhones(...$arguments)
 * @method getLists(...$arguments)
 * @method getMutual(...$arguments)
 * @method getOnline(...$arguments)
 * @method getRecent(...$arguments)
 * @method getRequests(...$arguments)
 * @method getSuggestions(...$arguments)
 * @method search(...$arguments)
 */
class Friends extends Method
{
    private VkApiRequest $request;

    public function __construct(VkApiRequest $request)
    {
        $this->request = $request;
    }

    public function __call($method, $parameters)
    {
        if (isset($parameters[0])) {
            if (is_array($parameters[0])) {
                $parameters = $parameters[0];
            }
        }
        return $this->request->apiRequest(Utils::classNameToMethod(__CLASS__) . '.' . $method, $parameters);
    }
}

