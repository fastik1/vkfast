<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Interfaces\MethodInterface;
use Fastik1\Vkfast\Utils;
use Fastik1\Vkfast\Api\VkApiRequest;

/**
 * @method addCompanyGroupsMembers(...$arguments)
 * @method addCompanyMembers(...$arguments)
 * @method changeBugreportStatus(...$arguments)
 * @method createComment(...$arguments)
 * @method getCompanyGroupMembers(...$arguments)
 * @method getCompanyMembers(...$arguments)
 * @method getProductBuildUploadServer(...$arguments)
 * @method removeCompanyGroupMember(...$arguments)
 * @method removeCompanyMember(...$arguments)
 * @method saveProductVersion(...$arguments)
 * @method setCompanyMemberRole(...$arguments)
 * @method setProductIsOver(...$arguments)
 */
class Bugtracker implements MethodInterface
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

