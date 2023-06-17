<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Api\VkApiRequest;
use Fastik1\Vkfast\Utils;

/**
 * @method get(...$arguments)
 * @method markAsViewed(...$arguments)
 * @method sendMessage(...$arguments)
 */
class Notifications extends Method
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

