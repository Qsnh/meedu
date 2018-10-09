<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Models\Order;
use App\Models\Video;
use App\Models\VideoComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SimpleMessageNotification;
use App\Http\Requests\Frontend\CourseOrVideoCommentCreateRequest;

class VideoController extends FrontendController
{
    public function show($courseId, $id, $slug)
    {
        $video = Video::with(['course', 'comments', 'user', 'comments.user'])
            ->published()
            ->show()
            ->whereId($id)
            ->firstOrFail();
        $title = sprintf('视频《%s》', $video->title);
        $keywords = $video->keywords;
        $description = $video->description;

        return view('frontend.video.show', compact('video', 'title', 'keywords', 'description'));
    }

    public function commentHandler(CourseOrVideoCommentCreateRequest $request, $videoId)
    {
        $video = Video::findOrFail($videoId);
        $comment = $video->commentHandler($request->input('content'));
        $comment ? flash('评论成功', 'success') : flash('评论失败');

        return back();
    }

    public function showBuyPage($id)
    {
        $video = Video::findOrFail($id);
        $title = sprintf('购买视频《%s》', $video->title);

        return view('frontend.video.buy', compact('video', compact('title')));
    }

    public function buyHandler($id)
    {
        $video = Video::findOrFail($id);
        $user = Auth::user();
        $videoUrl = route('video.show', [$video->course->id, $video->id, $video->slug]);

        if ($user->buyVideos()->whereId($video->id)->exists()) {
            flash('您已经购买过本视频啦', 'success');

            return redirect($videoUrl);
        }
        if ($user->credit1 < $video->charge) {
            flash('余额不足，请先充值', 'warning');

            return redirect(route('member.recharge'));
        }

        DB::beginTransaction();
        try {
            // 创建订单记录
            $order = $user->orders()->save(new Order([
                'goods_id' => $video->id,
                'goods_type' => Order::GOODS_TYPE_VIDEO,
                'charge' => $video->charge,
                'status' => Order::STATUS_PAID,
            ]));
            // 购买视频
            $user->buyAVideo($video);
            // 扣除余额
            $user->credit1Dec($video->charge);
            // 消息通知
            $user->notify(new SimpleMessageNotification($order->getNotificationContent()));

            DB::commit();

            flash('购买成功', 'success');

            return redirect($videoUrl);
        } catch (Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            flash('购买失败', 'warning');

            return back();
        }
    }
}
