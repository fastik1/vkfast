<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Api\VkApiRequest;
use Fastik1\Vkfast\Utils;

/**
 * @method addAppEvent(...$arguments)
 * @method checkToken(...$arguments)
 * @method getAppBalance(...$arguments)
 * @method getSMSHistory(...$arguments)
 * @method getTransactionsHistory(...$arguments)
 * @method getUserLevel(...$arguments)
 * @method giveEventSticker(...$arguments)
 * @method sendNotification(...$arguments)
 * @method sendSMSNotification(...$arguments)
 * @method setCounter(...$arguments)
 * @method setUserLevel(...$arguments)
 */
class Secure extends Method
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

