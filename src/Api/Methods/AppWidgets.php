<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Api\VkApiRequest;
use Fastik1\Vkfast\Utils;

/**
 * @method getAppImageUploadServer(...$arguments)
 * @method getAppImages(...$arguments)
 * @method getGroupImageUploadServer(...$arguments)
 * @method getGroupImages(...$arguments)
 * @method getImagesById(...$arguments)
 * @method saveAppImage(...$arguments)
 * @method saveGroupImage(...$arguments)
 * @method update(...$arguments)
 */
class AppWidgets extends Method
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

