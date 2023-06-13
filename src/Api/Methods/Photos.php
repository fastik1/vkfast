<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Interfaces\MethodInterface;
use Fastik1\Vkfast\Utils;
use Fastik1\Vkfast\Api\VkApiRequest;

/**
 * @method confirmTag(...$arguments)
 * @method copy(...$arguments)
 * @method createAlbum(...$arguments)
 * @method createComment(...$arguments)
 * @method delete(...$arguments)
 * @method deleteAlbum(...$arguments)
 * @method deleteComment(...$arguments)
 * @method edit(...$arguments)
 * @method editAlbum(...$arguments)
 * @method editComment(...$arguments)
 * @method get(...$arguments)
 * @method getAlbums(...$arguments)
 * @method getAlbumsCount(...$arguments)
 * @method getAll(...$arguments)
 * @method getAllComments(...$arguments)
 * @method getById(...$arguments)
 * @method getChatUploadServer(...$arguments)
 * @method getComments(...$arguments)
 * @method getMailUploadServer(...$arguments)
 * @method getMarketAlbumUploadServer(...$arguments)
 * @method getMarketUploadServer(...$arguments)
 * @method getMessagesUploadServer(...$arguments)
 * @method getNewTags(...$arguments)
 * @method getOwnerCoverPhotoUploadServer(...$arguments)
 * @method getOwnerPhotoUploadServer(...$arguments)
 * @method getProfile(...$arguments)
 * @method getTags(...$arguments)
 * @method getUploadServer(...$arguments)
 * @method getUserPhotos(...$arguments)
 * @method getWallUploadServer(...$arguments)
 * @method makeCover(...$arguments)
 * @method move(...$arguments)
 * @method putTag(...$arguments)
 * @method removeTag(...$arguments)
 * @method reorderAlbums(...$arguments)
 * @method reorderPhotos(...$arguments)
 * @method report(...$arguments)
 * @method reportComment(...$arguments)
 * @method restore(...$arguments)
 * @method restoreComment(...$arguments)
 * @method save(...$arguments)
 * @method saveMailPhoto(...$arguments)
 * @method saveMarketAlbumPhoto(...$arguments)
 * @method saveMarketPhoto(...$arguments)
 * @method saveMessagesPhoto(...$arguments)
 * @method saveOwnerCoverPhoto(...$arguments)
 * @method saveOwnerPhoto(...$arguments)
 * @method saveWallPhoto(...$arguments)
 * @method search(...$arguments)
 */
class Photos implements MethodInterface
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

