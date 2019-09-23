<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-primary">
                <p class="no-padding no-margin">1.支持Markdown语法</p>
                <p class="no-padding no-margin">2.支持 @ 某个人，格式：<code>@昵称+一个空格</code>，如：<code>@小滕 </code></p>
                <p class="no-padding no-margin">3.支持拖拽图片到评论框上传</p>
                <p class="no-padding no-margin">4.支持emoji表情</p>
            </div>
            <div class="publisher publisher-multi bg-white b-1 mb-30">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <textarea class="publisher-input auto-expand" name="comment_content" id="comment-content" rows="2" placeholder="写点吧"></textarea>
                    <p class="text-right"><button type="button" id="submit-comment" class="btn btn-sm btn-bold btn-primary">评论</button></p>
                    @else
                    <textarea class="publisher-input auto-expand bg-dark" name="comment_content" id="comment-content" rows="1" placeholder="请先登录" disabled="disabled"></textarea>
                @endif
            </div>
        </div>
        <div class="col-sm-12 comment-box">
            @foreach($comments as $comment)
            <div class="card">
                <div class="card-body">
                    <div class="media bb-1 border-fade">
                        <img class="avatar avatar-lg" src="{{$comment->user->avatar}}">
                        <div class="media-body">
                            <p>
                                <strong class="fs-14">{{$comment->user->nick_name}}</strong>
                                <time class="float-right text-lighter" datetime="{{$comment->created_at}}">{{$comment->created_at->diffForHumans()}}</time>
                            </p>
                            <p>
                                @if($comment->user->role)
                                    <span class="badge badge-primary">{{$comment->user->role->name}}</span>
                                @else
                                    <span class="badge badge-default">免费会员</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="card-body border-fade">
                        {!! $comment->getContent() !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@section('js')
    <script>
        var submitBtn = document.getElementById('submit-comment');
        submitBtn.addEventListener('click', function () {
           var content = document.getElementById('comment-content').value;
           if (content === '') {
                swal('Oops', '请输入内容', 'error');
                return;
           }
            $(this).attr('disabled', true);
            $.post("{{$submitUrl}}", {
                'content': $('textarea[name="comment_content"]').val(),
                '_token': '{{csrf_token()}}'
            }, function (res) {
                $('#submit-comment').removeAttr('disabled');
                if (typeof res.status !== 'undefined' || typeof res.code !== 'undefined') {
                    swal("失败", res.message, "error");
                } else {
                    $('textarea[name="comment_content"]').val('');
                    $('.comment-box').prepend(`
            <div class="card">
                <div class="card-body">
                    <div class="media bb-1 border-fade">
                        <img class="avatar avatar-lg" src="${res.user.avatar}">
                        <div class="media-body">
                            <p>
                                <strong class="fs-14">${res.user.nick_name}</strong>
                                <time class="float-right text-lighter">${res.created_at}</time>
                            </p>
                            <p>
${res.user.role}
                        </p>
                    </div>
                </div>
                <div class="card-body border-fade">
${res.content}
                        </div>
                    </div>
                </div>
`);
                }
            }, 'json');
        });
    </script>
    @endsection