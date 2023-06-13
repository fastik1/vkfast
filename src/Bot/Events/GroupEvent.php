<?php


namespace Fastik1\Vkfast\Bot\Events;


class GroupEvent
{
    const CONFIRMATION = "confirmation";

    const MESSAGE_NEW = "message_new";
    const MESSAGE_REPLY = "message_reply";
    const MESSAGE_EDIT = "message_edit";
    const MESSAGE_ALLOW = "message_allow";
    const MESSAGE_DENY = "message_deny";
    const MESSAGE_TYPING_STATE = "message_typing_state";
    const MESSAGE_EVENT = "message_event";
    const MESSAGE_REACTION_EVENT = "message_reaction_event";
    const MESSAGE_READ = "message_read";

    const PHOTO_NEW = "photo_new";
    const PHOTO_COMMENT_NEW = "photo_comment_new";
    const PHOTO_COMMENT_EDIT = "photo_comment_edit";
    const PHOTO_COMMENT_RESTORE = "photo_comment_restore";
    const PHOTO_COMMENT_DELETE = "photo_comment_delete";

    const AUDIO_NEW = "audio_new";

    const VIDEO_NEW = "video_new";
    const VIDEO_COMMENT_NEW = "video_comment_new";
    const VIDEO_COMMENT_EDIT = "video_comment_edit";
    const VIDEO_COMMENT_RESTORE = "video_comment_restore";
    const VIDEO_COMMENT_DELETE = "video_comment_delete";

    const WALL_POST_NEW = "wall_post_new";
    const WALL_REPOST = "wall_repost";
    const WALL_REPLY_NEW = "wall_reply_new";
    const WALL_REPLY_EDIT = "wall_reply_edit";
    const WALL_REPLY_RESTORE = "wall_reply_restore";
    const WALL_REPLY_DELETE = "wall_reply_delete";

    const LIKE_ADD = "like_add";
    const LIKE_REMOVE = "like_remove";

    const BOARD_POST_NEW = "board_post_new";
    const BOARD_POST_EDIT = "board_post_edit";
    const BOARD_POST_RESTORE = "board_post_restore";
    const BOARD_POST_DELETE = "board_post_delete";

    const MARKET_COMMENT_NEW = "market_comment_new";
    const MARKET_COMMENT_EDIT = "market_comment_edit";
    const MARKET_COMMENT_RESTORE = "market_comment_restore";
    const MARKET_COMMENT_DELETE = "market_comment_delete";

    const MARKET_ORDER_NEW = "market_order_new";
    const MARKET_ORDER_EDIT = "market_order_edit";

    const GROUP_LEAVE = "group_leave";
    const GROUP_JOIN = "group_join";

    const USER_BLOCK = "user_block";
    const USER_UNBLOCK = "user_unblock";

    const POLL_VOTE_NEW = "poll_vote_new";

    const GROUP_OFFICERS_EDIT = "group_officers_edit";

    const GROUP_CHANGE_SETTINGS = "group_change_settings";
    const GROUP_CHANGE_PHOTO = "group_change_photo";

    const VKPAY_TRANSACTION = "vkpay_transaction";
    const APP_PAYLOAD = "app_payload";

    const DONUT_SUBSCRIPTION_CREATE = "donut_subscription_create";
    const DONUT_SUBSCRIPTION_PROLONGED = "donut_subscription_prolonged";
    const DONUT_SUBSCRIPTION_EXPIRED = "donut_subscription_expired";
    const DONUT_SUBSCRIPTION_CANCELLED = "donut_subscription_cancelled";
    const DONUT_SUBSCRIPTION_PRICE_CHANGED = "donut_subscription_price_changed";
    const DONUT_MONEY_WITHDRAW = "donut_money_withdraw";
    const DONUT_MONEY_WITHDRAW_ERROR = "donut_money_withdraw_error";
}