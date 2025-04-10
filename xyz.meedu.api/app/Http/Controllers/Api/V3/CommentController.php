<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V3;

use App\Meedu\Utils\IP;
use App\Meedu\Core\HashID;
use App\Meedu\Hooks\HookRun;
use Illuminate\Http\Request;
use App\Http\Requests\ApiV3\CommentRequest;
use App\Meedu\Hooks\Constant\PositionConstant;
use App\Http\Controllers\Api\V2\BaseController;
use App\Meedu\Cache\Impl\CommentStoreLimitCache;
use App\Meedu\ServiceV2\Services\UserServiceInterface;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;
use App\Meedu\ServiceV2\Services\CommentServiceInterface;

class CommentController extends BaseController
{
    /**
     * @api {GET} /api/v3/comment [V3]评论-获取评论列表
     * @apiGroup 评论模块
     * @apiName GetCommentList
     *
     * @apiParam {Number} rt 资源类型ID
     * @apiParam {Number} rid 资源ID
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {Array} data.data 评论列表
     * @apiSuccess {String} data.data.id 评论ID
     * @apiSuccess {String} data.data.parent_id 父评论ID
     * @apiSuccess {String} data.data.reply_id 回复评论ID
     * @apiSuccess {String} data.data.content 评论内容
     * @apiSuccess {String} data.data.ip_province IP所属省份
     * @apiSuccess {Number} data.data.is_check 是否审核通过[1:是,0:等待审核]
     * @apiSuccess {String} data.data.created_at 创建时间
     * @apiSuccess {Number} data.data.replies_count 回复数量
     * @apiSuccess {Array} data.data.replies 回复列表
     * @apiSuccess {String} data.data.replies.id 回复ID
     * @apiSuccess {String} data.data.replies.parent_id 父评论ID
     * @apiSuccess {String} data.data.replies.reply_id 回复评论ID
     * @apiSuccess {String} data.data.replies.content 回复内容
     * @apiSuccess {String} data.data.replies.ip_province IP所属省份
     * @apiSuccess {Number} data.data.replies.is_check 是否审核通过
     * @apiSuccess {String} data.data.replies.created_at 创建时间
     * @apiSuccess {Object} data.data.replies.user 用户信息
     * @apiSuccess {String} data.data.replies.user.avatar 用户头像
     * @apiSuccess {String} data.data.replies.user.nick_name 用户昵称
     * @apiSuccess {Object} data.data.replies.reply_user 被回复用户信息(互评)
     * @apiSuccess {String} data.data.replies.reply_user.avatar 被回复用户头像
     * @apiSuccess {String} data.data.replies.reply_user.nick_name 被回复用户昵称
     * @apiSuccess {Object} data.data.user 评论用户信息
     * @apiSuccess {String} data.data.user.avatar 评论用户头像
     * @apiSuccess {String} data.data.user.nick_name 评论用户昵称
     * @apiSuccess {Number} data.total 总评论数
     */
    public function index(
        Request                 $request,
        CommentServiceInterface $commentService,
        UserServiceInterface    $userService
    ) {
        $rt = max(1, $request->input('rt', 1));
        $rid = max(1, $request->input('rid', 1));

        $result = $commentService->comments($rt, $rid);

        // 获取评论关联的用户信息
        $userIds = [];
        foreach ($result['data'] as $comment) {
            $userIds[] = $comment['user_id'];
            if ($comment['replies']) {
                $userIds = array_merge($userIds, array_column($comment['replies'], 'user_id'));
                foreach ($comment['replies'] as $replyCommentItem) {
                    if ($replyCommentItem['reply_comment']) {
                        $userIds[] = $replyCommentItem['user_id'];
                    }
                }
            }
        }

        if ($userIds) {
            $users = $userService->getUsersBasicInfo(array_unique($userIds));
            $users = array_column($users, null, 'id');
            foreach ($result['data'] as $key => $comment) {
                $tmpUser = $users[$comment['user_id']] ?? [];
                if ($tmpUser) {
                    unset($tmpUser['id']);
                }
                $result['data'][$key]['user'] = $tmpUser;

                // 子回复列表
                if ($comment['replies']) {
                    foreach ($comment['replies'] as $replyKey => $reply) {
                        $tmpUser = $users[$reply['user_id']] ?? [];
                        if ($tmpUser) {
                            unset($tmpUser['id']);
                        }
                        $result['data'][$key]['replies'][$replyKey]['user'] = $tmpUser;

                        // 互评信息
                        if ($reply['reply_comment']) {
                            $tmpUser = $users[$reply['reply_comment']['user_id']] ?? [];
                            if ($tmpUser) {
                                unset($tmpUser['id']);
                            }
                            $result['data'][$key]['replies'][$replyKey]['reply_user'] = $tmpUser;
                        }

                        unset($result['data'][$key]['replies'][$replyKey]['reply_comment']);
                    }
                }
            }
        }

        foreach ($result['data'] as $commentKey => $commentItem) {
            $result['data'][$commentKey]['id'] = HashID::encode($commentItem['id']);
            $result['data'][$commentKey]['parent_id'] = HashID::encode($commentItem['parent_id']);
            $result['data'][$commentKey]['reply_id'] = HashID::encode($commentItem['reply_id']);

            unset($result['data'][$commentKey]['user_id']);

            if ($commentItem['replies']) {
                foreach ($commentItem['replies'] as $replyKey => $reply) {
                    $result['data'][$commentKey]['replies'][$replyKey]['id'] = HashID::encode($reply['id']);
                    $result['data'][$commentKey]['replies'][$replyKey]['reply_id'] = HashID::encode($reply['reply_id']);
                    $result['data'][$commentKey]['replies'][$replyKey]['parent_id'] = HashID::encode($reply['parent_id']);

                    unset($result['data'][$commentKey]['replies'][$replyKey]['user_id']);
                }
            }
        }

        return $this->data($result);
    }

    /**
     * @api {GET} /api/v3/comment/replies [V3]评论-获取更多评论
     * @apiGroup 评论模块
     * @apiName GetCommentReplies1
     *
     * @apiParam {Number} rt 资源类型ID
     * @apiParam {Number} rid 资源ID
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {Array} data.data 回复列表
     * @apiSuccess {String} data.data.id 回复ID
     * @apiSuccess {String} data.data.parent_id 父评论ID
     * @apiSuccess {String} data.data.reply_id 回复评论ID
     * @apiSuccess {String} data.data.content 回复内容
     * @apiSuccess {String} data.data.ip_province IP所属省份
     * @apiSuccess {Number} data.data.is_check 是否审核通过[1:是,0:等待审核]
     * @apiSuccess {String} data.data.created_at 创建时间
     * @apiSuccess {Number} data.data.replies_count 回复数量
     * @apiSuccess {Array} data.data.replies 子回复列表
     * @apiSuccess {String} data.data.replies.id 子回复ID
     * @apiSuccess {String} data.data.replies.parent_id 父评论ID
     * @apiSuccess {String} data.data.replies.reply_id 回复评论ID
     * @apiSuccess {String} data.data.replies.content 子回复内容
     * @apiSuccess {String} data.data.replies.ip_province IP所属省份
     * @apiSuccess {Number} data.data.replies.is_check 是否审核通过[1:是,0:等待审核]
     * @apiSuccess {String} data.data.replies.created_at 创建时间
     * @apiSuccess {Object} data.data.replies.user 用户信息
     * @apiSuccess {String} data.data.replies.user.avatar 用户头像
     * @apiSuccess {String} data.data.replies.user.nick_name 用户昵称
     * @apiSuccess {Object} data.data.replies.reply_user 被回复用户信息(互评)
     * @apiSuccess {String} data.data.replies.reply_user.avatar 被回复用户头像
     * @apiSuccess {String} data.data.replies.reply_user.nick_name 被回复用户昵称
     * @apiSuccess {Object} data.data.user 回复用户信息
     * @apiSuccess {String} data.data.user.avatar 回复用户头像
     * @apiSuccess {String} data.data.user.nick_name 回复用户昵称
     */

    /**
     * @api {GET} /api/v3/comment/replies [V3]评论-获取更多回复
     * @apiGroup 评论模块
     * @apiName GetCommentReplies2
     *
     * @apiParam {Number} rt 资源类型ID
     * @apiParam {Number} rid 资源ID
     * @apiParam {String} parent_id 父评论ID
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {Array} data.data 回复列表
     * @apiSuccess {String} data.data.id 回复ID
     * @apiSuccess {String} data.data.parent_id 父评论ID
     * @apiSuccess {String} data.data.reply_id 回复评论ID
     * @apiSuccess {String} data.data.content 回复内容
     * @apiSuccess {String} data.data.ip_province IP所属省份
     * @apiSuccess {Number} data.data.is_check 是否审核通过[1:是,0:等待审核]
     * @apiSuccess {String} data.data.created_at 创建时间
     * @apiSuccess {Object} data.data.user 评论用户信息
     * @apiSuccess {String} data.data.user.avatar 评论用户头像
     * @apiSuccess {String} data.data.user.nick_name 评论用户昵称
     * @apiSuccess {Object} data.data.reply_user 被回复用户信息(互评)
     * @apiSuccess {String} data.data.reply_user.avatar 被回复用户头像
     * @apiSuccess {String} data.data.reply_user.nick_name 被回复用户昵称
     */
    public function replies(
        Request                 $request,
        CommentServiceInterface $commentService,
        UserServiceInterface    $userService
    ) {
        $rt = max(1, $request->input('rt', 1));
        $rid = max(1, $request->input('rid', 1));
        $parentId = $request->input('parent_id');

        if ($parentId) {
            $parentId = HashID::decode($parentId);
            if (false === $parentId) {
                return $this->error(__('参数错误'));
            }
        } else {
            $parentId = 0;
        }

        $replies = $commentService->replies($rt, $rid, $parentId);

        // 获取评论关联的用户信息
        $userIds = array_column($replies, 'user_id');
        if ($replies) {
            foreach ($replies as $tmpReplyItem) {
                $userIds[] = $tmpReplyItem['user_id'];

                // 子回复列表
                if (isset($tmpReplyItem['replies']) && $tmpReplyItem['replies']) {
                    $userIds = array_merge(
                        $userIds,
                        array_column($tmpReplyItem['replies'], 'user_id')
                    );
                    foreach ($tmpReplyItem['replies'] as $tmpItem) {
                        if (!$tmpItem['reply_comment']) {
                            continue;
                        }
                        $userIds[] = $tmpItem['reply_comment']['user_id'];
                    }
                }

                // 互评
                if (isset($replies['reply_comment']) && $replies['reply_comment']) {
                    $userIds[] = $replies['reply_comment']['user_id'];
                }
            }
        }

        if ($userIds) {
            $users = $userService->getUsersBasicInfo(array_unique($userIds));
            $users = array_column($users, null, 'id');
            foreach ($replies as $replyKey => $tmpReplyItem) {
                $tmpUser = $users[$tmpReplyItem['user_id']] ?? [];
                if ($tmpUser) {
                    unset($tmpUser['id']);
                }
                $replies[$replyKey]['user'] = $tmpUser;

                // 子回复列表
                if (isset($tmpReplyItem['replies']) && $tmpReplyItem['replies']) {
                    foreach ($tmpReplyItem['replies'] as $replyCommentKey => $replyCommentItem) {
                        $tmpUser = $users[$replyCommentItem['user_id']] ?? [];
                        if ($tmpUser) {
                            unset($tmpUser['id']);
                        }
                        $replies[$replyKey]['replies'][$replyCommentKey]['user'] = $tmpUser;

                        // 互评信息
                        if ($replyCommentItem['reply_comment']) {
                            $tmpUser = $users[$replyCommentItem['reply_comment']['user_id']] ?? [];
                            if ($tmpUser) {
                                unset($tmpUser['id']);
                            }
                            $replies[$replyKey]['replies'][$replyCommentKey]['reply_user'] = $tmpUser;
                        }
                        unset($replies[$replyKey]['replies'][$replyCommentKey]['reply_comment']);
                    }
                }

                // 互评信息
                if (isset($tmpReplyItem['reply_comment']) && $tmpReplyItem['reply_comment']) {
                    $tmpUser = $users[$tmpReplyItem['reply_comment']['user_id']] ?? [];
                    if ($tmpUser) {
                        unset($tmpUser['id']);
                    }
                    $replies[$replyKey]['reply_user'] = $tmpUser;
                }

                unset($replies[$replyKey]['reply_comment']);
            }
        }

        if ($replies) {
            foreach ($replies as $replyKey => $replyItem) {
                $replies[$replyKey]['id'] = HashID::encode($replyItem['id']);
                $replies[$replyKey]['parent_id'] = HashID::encode($replyItem['parent_id']);
                $replies[$replyKey]['reply_id'] = HashID::encode($replyItem['reply_id']);
                unset($replies[$replyKey]['user_id']);

                if (isset($replyItem['replies']) && $replyItem['replies']) {
                    foreach ($replyItem['replies'] as $replyCommentKey => $replyCommentItem) {
                        $replies[$replyKey]['replies'][$replyCommentKey]['id'] = HashID::encode($replyCommentItem['id']);
                        $replies[$replyKey]['replies'][$replyCommentKey]['parent_id'] = HashID::encode($replyCommentItem['parent_id']);
                        $replies[$replyKey]['replies'][$replyCommentKey]['reply_id'] = HashID::encode($replyCommentItem['reply_id']);
                        unset($replies[$replyKey]['replies'][$replyCommentKey]['user_id']);
                    }
                }
            }
        }

        return $this->data([
            'data' => $replies,
        ]);
    }

    /**
     * @api {POST} /api/v3/comment/store [V3]评论-提交评论
     * @apiGroup 评论模块
     * @apiName CommentStore
     *
     * @apiParam {Number} rt 资源类型ID
     * @apiParam {Number} rid 资源ID
     * @apiParam {String} content 评论内容
     * @apiParam {String} parent_id 父评论ID
     * @apiParam {String} reply_id 回复ID
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.id 评论ID
     * @apiSuccess {String} data.reply_id 回复ID
     * @apiSuccess {String} data.parent_id 父ID
     * @apiSuccess {Object} data.user
     * @apiSuccess {String} data.user.nick_name 昵称
     * @apiSuccess {String} data.user.avatar 头像
     */
    public function store(
        CommentRequest          $request,
        CommentServiceInterface $commentService,
        CommentStoreLimitCache  $limitCache,
        ConfigServiceInterface  $configService
    ) {
        $loginUser = $this->user();

        if (!$limitCache->canComment($loginUser['id'])) {
            return $this->error(__('已超出每日评论限制'));
        }

        $data = $request->filldata();
        if ($data['parent_id']) {
            $data['parent_id'] = HashID::decode($data['parent_id']);
        }
        if ($data['reply_id']) {
            $data['reply_id'] = HashID::decode($data['reply_id']);
        }
        if (false === $data['parent_id'] || false === $data['reply_id']) {
            return $this->error(__('参数错误'));
        }

        $rtWhitelist = $configService->getCommentRTWhiteList();
        if (!in_array($data['rt'], $rtWhitelist)) {
            return $this->error(__('参数错误'));
        }

        $ip = $request->getClientIp();
        $province = IP::queryProvince($ip);
        $data = array_merge($data, [
            'ip' => $ip,
            'province' => $province,
            'user_id' => $loginUser['id'],
        ]);

        HookRun::subscribe(PositionConstant::COMMENT_STORE_CHECK, $data);

        $comment = $commentService->create($data);

        $comment['id'] = HashID::encode($comment['id']);
        $comment['reply_id'] = HashID::encode($comment['reply_id']);
        $comment['parent_id'] = HashID::encode($comment['parent_id']);

        $limitCache->incrementUserDailyCommentCount($loginUser['id']);

        // 评论的学员相关信息
        $comment['user'] = [
            'nick_name' => $loginUser['nick_name'],
            'avatar' => $loginUser['avatar'],
        ];

        return $this->data($comment);
    }
}
