<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Interfaces\MethodInterface;
use Fastik1\Vkfast\Utils;
use Fastik1\Vkfast\Api\VkApiRequest;

/**
 * @method clearCache(...$arguments)
 * @method get(...$arguments)
 * @method getHistory(...$arguments)
 * @method getTitles(...$arguments)
 * @method getVersion(...$arguments)
 * @method parseWiki(...$arguments)
 * @method preview(...$arguments)
 * @method save(...$arguments)
 * @method saveAccess(...$arguments)
 */
class Pages implements MethodInterface
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

