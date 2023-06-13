<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Interfaces\MethodInterface;
use Fastik1\Vkfast\Utils;
use Fastik1\Vkfast\Api\VkApiRequest;

/**
 * @method get(...$arguments)
 * @method getFollowers(...$arguments)
 * @method getSubscriptions(...$arguments)
 * @method report(...$arguments)
 * @method search(...$arguments)
 */
class Users implements MethodInterface
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

