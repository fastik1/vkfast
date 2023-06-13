<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Interfaces\MethodInterface;
use Fastik1\Vkfast\Utils;
use Fastik1\Vkfast\Api\VkApiRequest;

/**
 * @method banOwner(...$arguments)
 * @method delete(...$arguments)
 * @method get(...$arguments)
 * @method getBanned(...$arguments)
 * @method getById(...$arguments)
 * @method getDetailedStats(...$arguments)
 * @method getPhotoUploadServer(...$arguments)
 * @method getReplies(...$arguments)
 * @method getStats(...$arguments)
 * @method getVideoUploadServer(...$arguments)
 * @method getViewers(...$arguments)
 * @method hideAllReplies(...$arguments)
 * @method hideReply(...$arguments)
 * @method save(...$arguments)
 * @method search(...$arguments)
 * @method sendInteraction(...$arguments)
 * @method unbanOwner(...$arguments)
 */
class Stories implements MethodInterface
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

