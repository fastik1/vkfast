<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Interfaces\MethodInterface;
use Fastik1\Vkfast\Utils;
use Fastik1\Vkfast\Api\VkApiRequest;

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
 * @method get(...$arguments)
 * @method getAlbumById(...$arguments)
 * @method getAlbums(...$arguments)
 * @method getAlbumsByVideo(...$arguments)
 * @method getComments(...$arguments)
 * @method getLongPollServer(...$arguments)
 * @method getNewTags(...$arguments)
 * @method getTags(...$arguments)
 * @method liveGetCategories(...$arguments)
 * @method moveToAlbum(...$arguments)
 * @method putTag(...$arguments)
 * @method removeFromAlbum(...$arguments)
 * @method removeTag(...$arguments)
 * @method reorderAlbums(...$arguments)
 * @method reorderVideos(...$arguments)
 * @method report(...$arguments)
 * @method reportComment(...$arguments)
 * @method restore(...$arguments)
 * @method restoreComment(...$arguments)
 * @method save(...$arguments)
 * @method search(...$arguments)
 * @method startStreaming(...$arguments)
 * @method stopStreaming(...$arguments)
 */
class Video implements MethodInterface
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

