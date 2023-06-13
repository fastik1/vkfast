<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Interfaces\MethodInterface;
use Fastik1\Vkfast\Utils;
use Fastik1\Vkfast\Api\VkApiRequest;

/**
 * @method addChatUser(...$arguments)
 * @method allowMessagesFromGroup(...$arguments)
 * @method createChat(...$arguments)
 * @method delete(...$arguments)
 * @method deleteChatPhoto(...$arguments)
 * @method deleteConversation(...$arguments)
 * @method denyMessagesFromGroup(...$arguments)
 * @method edit(...$arguments)
 * @method editChat(...$arguments)
 * @method forceCallFinish(...$arguments)
 * @method get(...$arguments)
 * @method getByConversationMessageId(...$arguments)
 * @method getById(...$arguments)
 * @method getChat(...$arguments)
 * @method getChatPreview(...$arguments)
 * @method getChatUsers(...$arguments)
 * @method getConversationMembers(...$arguments)
 * @method getConversations(...$arguments)
 * @method getConversationsById(...$arguments)
 * @method getDialogs(...$arguments)
 * @method getHistory(...$arguments)
 * @method getHistoryAttachments(...$arguments)
 * @method getImportantMessages(...$arguments)
 * @method getIntentUsers(...$arguments)
 * @method getInviteLink(...$arguments)
 * @method getLastActivity(...$arguments)
 * @method getLongPollHistory(...$arguments)
 * @method getLongPollServer(...$arguments)
 * @method getMessagesReactions(...$arguments)
 * @method getReactedPeers(...$arguments)
 * @method getReactionsAssets(...$arguments)
 * @method isMessagesFromGroupAllowed(...$arguments)
 * @method joinChatByInviteLink(...$arguments)
 * @method markAsAnsweredConversation(...$arguments)
 * @method markAsImportant(...$arguments)
 * @method markAsImportantConversation(...$arguments)
 * @method markAsRead(...$arguments)
 * @method pin(...$arguments)
 * @method removeChatUser(...$arguments)
 * @method restore(...$arguments)
 * @method search(...$arguments)
 * @method searchConversations(...$arguments)
 * @method searchDialogs(...$arguments)
 * @method send(...$arguments)
 * @method sendMessageEventAnswer(...$arguments)
 * @method sendReaction(...$arguments)
 * @method setActivity(...$arguments)
 * @method setChatPhoto(...$arguments)
 * @method startCall(...$arguments)
 * @method unpin(...$arguments)
 */
class Messages implements MethodInterface
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

