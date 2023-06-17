<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Api\VkApiRequest;
use Fastik1\Vkfast\Utils;

/**
 * @method add(...$arguments)
 * @method addAlbum(...$arguments)
 * @method addToAlbum(...$arguments)
 * @method createComment(...$arguments)
 * @method delete(...$arguments)
 * @method deleteAlbum(...$arguments)
 * @method deleteComment(...$arguments)
 * @method edit(...$arguments)
 * @method editAlbum(...$arguments)
 * @method editComment(...$arguments)
 * @method editOrder(...$arguments)
 * @method filterCategories(...$arguments)
 * @method get(...$arguments)
 * @method getAlbumById(...$arguments)
 * @method getAlbums(...$arguments)
 * @method getById(...$arguments)
 * @method getCategories(...$arguments)
 * @method getComments(...$arguments)
 * @method getGroupOrders(...$arguments)
 * @method getOrderById(...$arguments)
 * @method getOrderItems(...$arguments)
 * @method getOrders(...$arguments)
 * @method removeFromAlbum(...$arguments)
 * @method reorderAlbums(...$arguments)
 * @method reorderItems(...$arguments)
 * @method report(...$arguments)
 * @method reportComment(...$arguments)
 * @method restore(...$arguments)
 * @method restoreComment(...$arguments)
 * @method search(...$arguments)
 * @method searchItems(...$arguments)
 * @method searchItemsBasic(...$arguments)
 */
class Market extends Method
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

