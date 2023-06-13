<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Interfaces\MethodInterface;
use Fastik1\Vkfast\Utils;
use Fastik1\Vkfast\Api\VkApiRequest;

/**
 * @method add(...$arguments)
 * @method delete(...$arguments)
 * @method edit(...$arguments)
 * @method get(...$arguments)
 * @method getById(...$arguments)
 * @method getMessagesUploadServer(...$arguments)
 * @method getTypes(...$arguments)
 * @method getUploadServer(...$arguments)
 * @method getWallUploadServer(...$arguments)
 * @method save(...$arguments)
 * @method search(...$arguments)
 */
class Docs implements MethodInterface
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

