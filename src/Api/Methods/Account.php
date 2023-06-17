<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Api\VkApiRequest;
use Fastik1\Vkfast\Utils;

/**
 * @method ban(...$arguments)
 * @method changePassword(...$arguments)
 * @method getActiveOffers(...$arguments)
 * @method getAppPermissions(...$arguments)
 * @method getBanned(...$arguments)
 * @method getCounters(...$arguments)
 * @method getInfo(...$arguments)
 * @method getProfileInfo(...$arguments)
 * @method getPushSettings(...$arguments)
 * @method lookupContacts(...$arguments)
 * @method registerDevice(...$arguments)
 * @method saveProfileInfo(...$arguments)
 * @method setInfo(...$arguments)
 * @method setNameInMenu(...$arguments)
 * @method setOffline(...$arguments)
 * @method setOnline(...$arguments)
 * @method setPushSettings(...$arguments)
 * @method setSilenceMode(...$arguments)
 * @method unban(...$arguments)
 * @method unregisterDevice(...$arguments)
 */
class Account extends Method
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

