<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Interfaces\MethodInterface;
use Fastik1\Vkfast\Utils;
use Fastik1\Vkfast\Api\VkApiRequest;

/**
 * @method addUsersToTestingGroup(...$arguments)
 * @method deleteAppRequests(...$arguments)
 * @method get(...$arguments)
 * @method getCatalog(...$arguments)
 * @method getFriendsList(...$arguments)
 * @method getLastUploadedVersion(...$arguments)
 * @method getLeaderboard(...$arguments)
 * @method getMiniAppPolicies(...$arguments)
 * @method getScopes(...$arguments)
 * @method getScore(...$arguments)
 * @method getTestingGroups(...$arguments)
 * @method isNotificationsAllowed(...$arguments)
 * @method promoHasActiveGift(...$arguments)
 * @method promoUseGift(...$arguments)
 * @method removeTestingGroup(...$arguments)
 * @method removeUsersFromTestingGroups(...$arguments)
 * @method sendRequest(...$arguments)
 * @method updateMetaForTestingGr(...$arguments)
 */
class Apps implements MethodInterface
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

