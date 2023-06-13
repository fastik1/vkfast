<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Interfaces\MethodInterface;
use Fastik1\Vkfast\Utils;
use Fastik1\Vkfast\Api\VkApiRequest;

/**
 * @method addBan(...$arguments)
 * @method deleteBan(...$arguments)
 * @method deleteList(...$arguments)
 * @method get(...$arguments)
 * @method getBanned(...$arguments)
 * @method getComments(...$arguments)
 * @method getLists(...$arguments)
 * @method getMentions(...$arguments)
 * @method getRecommended(...$arguments)
 * @method getSuggestedSources(...$arguments)
 * @method ignoreItem(...$arguments)
 * @method saveList(...$arguments)
 * @method search(...$arguments)
 * @method unignoreItem(...$arguments)
 * @method unsubscribe(...$arguments)
 */
class Newsfeed implements MethodInterface
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

