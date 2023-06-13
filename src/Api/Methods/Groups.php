<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Interfaces\MethodInterface;
use Fastik1\Vkfast\Utils;
use Fastik1\Vkfast\Api\VkApiRequest;

/**
 * @method addAddress(...$arguments)
 * @method addCallbackServer(...$arguments)
 * @method addLink(...$arguments)
 * @method approveRequest(...$arguments)
 * @method ban(...$arguments)
 * @method create(...$arguments)
 * @method deleteAddress(...$arguments)
 * @method deleteCallbackServer(...$arguments)
 * @method deleteLink(...$arguments)
 * @method disableOnline(...$arguments)
 * @method edit(...$arguments)
 * @method editAddress(...$arguments)
 * @method editCallbackServer(...$arguments)
 * @method editLink(...$arguments)
 * @method editManager(...$arguments)
 * @method editPlace(...$arguments)
 * @method enableOnline(...$arguments)
 * @method get(...$arguments)
 * @method getAddresses(...$arguments)
 * @method getBanned(...$arguments)
 * @method getById(...$arguments)
 * @method getCallbackConfirmationCode(...$arguments)
 * @method getCallbackServerSettings(...$arguments)
 * @method getCallbackServers(...$arguments)
 * @method getCallbackSettings(...$arguments)
 * @method getCatalog(...$arguments)
 * @method getCatalogInfo(...$arguments)
 * @method getInvitedUsers(...$arguments)
 * @method getInvites(...$arguments)
 * @method getLongPollServer(...$arguments)
 * @method getLongPollSettings(...$arguments)
 * @method getMembers(...$arguments)
 * @method getOnlineStatus(...$arguments)
 * @method getRequests(...$arguments)
 * @method getSettings(...$arguments)
 * @method getTagList(...$arguments)
 * @method getTokenPermissions(...$arguments)
 * @method invite(...$arguments)
 * @method isMember(...$arguments)
 * @method join(...$arguments)
 * @method leave(...$arguments)
 * @method removeUser(...$arguments)
 * @method reorderLink(...$arguments)
 * @method search(...$arguments)
 * @method setCallbackSettings(...$arguments)
 * @method setLongPollSettings(...$arguments)
 * @method setSettings(...$arguments)
 * @method setUserNote(...$arguments)
 * @method tagAdd(...$arguments)
 * @method tagBind(...$arguments)
 * @method tagDelete(...$arguments)
 * @method tagUpdate(...$arguments)
 * @method toggleMarket(...$arguments)
 * @method unban(...$arguments)
 */
class Groups implements MethodInterface
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

