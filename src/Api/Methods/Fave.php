<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Api\VkApiRequest;
use Fastik1\Vkfast\Utils;

/**
 * @method addArticle(...$arguments)
 * @method addLink(...$arguments)
 * @method addPage(...$arguments)
 * @method addPost(...$arguments)
 * @method addProduct(...$arguments)
 * @method addTag(...$arguments)
 * @method addVideo(...$arguments)
 * @method editTag(...$arguments)
 * @method get(...$arguments)
 * @method getPages(...$arguments)
 * @method getTags(...$arguments)
 * @method markSeen(...$arguments)
 * @method removeArticle(...$arguments)
 * @method removeLink(...$arguments)
 * @method removePage(...$arguments)
 * @method removePost(...$arguments)
 * @method removeProduct(...$arguments)
 * @method removeTag(...$arguments)
 * @method removeVideo(...$arguments)
 * @method reorderTags(...$arguments)
 * @method setPageTags(...$arguments)
 * @method setTags(...$arguments)
 * @method trackPageInteraction(...$arguments)
 */
class Fave extends Method
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

