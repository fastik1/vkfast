<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Interfaces\MethodInterface;
use Fastik1\Vkfast\Utils as UtilsClass;
use Fastik1\Vkfast\Api\VkApiRequest;

/**
 * @method checkLink(...$arguments)
 * @method deleteFromLastShortened(...$arguments)
 * @method getLastShortenedLinks(...$arguments)
 * @method getLinkStats(...$arguments)
 * @method getServerTime(...$arguments)
 * @method getShortLink(...$arguments)
 * @method resolveScreenName(...$arguments)
 */
class Utils implements MethodInterface
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
        return $this->request->apiRequest(UtilsClass::classNameToMethod(__CLASS__) . '.' . $method, $parameters);
    }
}

