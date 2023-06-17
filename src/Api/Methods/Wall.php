<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Api\VkApiRequest;
use Fastik1\Vkfast\Utils;

/**
 * @method addLike(...$arguments)
 * @method checkCopyrightLink(...$arguments)
 * @method closeComments(...$arguments)
 * @method createComment(...$arguments)
 * @method delete(...$arguments)
 * @method deleteComment(...$arguments)
 * @method deleteLike(...$arguments)
 * @method edit(...$arguments)
 * @method editAdsStealth(...$arguments)
 * @method editComment(...$arguments)
 * @method get(...$arguments)
 * @method getById(...$arguments)
 * @method getComment(...$arguments)
 * @method getComments(...$arguments)
 * @method getLikes(...$arguments)
 * @method getPhotoUploadServer(...$arguments)
 * @method getReposts(...$arguments)
 * @method openComments(...$arguments)
 * @method pin(...$arguments)
 * @method post(...$arguments)
 * @method postAdsStealth(...$arguments)
 * @method reportComment(...$arguments)
 * @method reportPost(...$arguments)
 * @method repost(...$arguments)
 * @method restore(...$arguments)
 * @method restoreComment(...$arguments)
 * @method search(...$arguments)
 * @method unpin(...$arguments)
 */
class Wall extends Method
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

