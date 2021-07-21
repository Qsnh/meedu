<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

use Carbon\Carbon;
use Overtrue\Pinyin\Pinyin;
use App\Services\Course\Models\Video;

class CourseVideoRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id' => 'required',
            'title' => 'required|max:255',
            'published_at' => 'required',
            'duration' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'course_id.required' => __('请选择视频所属课程'),
            'title.required' => __('请输入视频标题'),
            'title.max' => __('视频标题长度不能超过:size个字符', ['size' => 255]),
            'published_at.required' => __('请选择视频上架时间'),
            'duration.required' => __('请输入视频时长'),
        ];
    }

    public function filldata()
    {
        $data = [
            'user_id' => $this->input('user_id', 0),
            'course_id' => $this->input('course_id'),
            'title' => $this->input('title'),
            'slug' => $this->input('slug'),
            'url' => $this->input('url', '') ?? '',
            'aliyun_video_id' => $this->input('aliyun_video_id', '') ?? '',
            'tencent_video_id' => $this->input('tencent_video_id', '') ?? '',
            'view_num' => $this->input('view_num', 0),
            'short_description' => $this->input('short_description') ?? '',
            'original_desc' => $this->input('original_desc') ?? '',
            'render_desc' => $this->input('render_desc') ?? '',
            'seo_keywords' => (string)$this->input('seo_keywords', ''),
            'seo_description' => (string)$this->input('seo_description', ''),
            'published_at' => Carbon::parse($this->input('published_at'))->toDateTimeLocalString(),
            'is_show' => (int)$this->input('is_show'),
            'charge' => (int)$this->input('charge', 0),
            'chapter_id' => (int)$this->input('chapter_id', 0),
            'duration' => (int)$this->input('duration'),
            'is_ban_sell' => (int)$this->input('is_ban_sell', 0),
            'comment_status' => (int)$this->input('comment_status', Video::COMMENT_STATUS_CLOSE),
            'player_pc' => $this->input('player_pc', ''),
            'player_h5' => $this->input('player_h5', ''),
            'free_seconds' => (int)$this->input('free_seconds'),
            'ban_drag' => (int)$this->input('ban_drag', 0),
        ];

        if ($this->isMethod('post') && !$data['slug']) {
            $data['slug'] = implode('-', (new Pinyin())->convert($data['title']));
        }

        return $data;
    }
}
