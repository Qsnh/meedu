<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="publisher publisher-multi bg-white b-1 mb-30">
                @auth
                    <textarea class="publisher-input auto-expand" name="comment_content" id="comment-content" rows="2"
                              placeholder="写点吧"></textarea>
                    <p class="text-right">
                        <button type="button" id="submit-comment" class="btn btn-sm btn-bold btn-primary">评论</button>
                    </p>
                @else
                    <textarea class="publisher-input auto-expand" name="comment_content" id="comment-content" rows="1"
                              placeholder="请先登录" disabled="disabled"></textarea>
                @endauth
            </div>
        </div>
        <div class="col-sm-12 comment-box">
            @foreach($comments as $comment)
                <div class="card">
                    <div class="card-body">
                        <div class="media bb-1 border-fade">
                            <img class="avatar avatar-lg" src="{{$users[$comment['user_id']]['avatar'] ?? ''}}">
                            <div class="media-body">
                                <p>
                                    <strong class="fs-14">{{$users[$comment['user_id']]['nick_name']}}</strong>
                                    <time class="float-right text-lighter"
                                          datetime="{{$comment['created_at']}}">{{$comment['created_at']}}</time>
                                </p>
                                <p>
                                    @if($users[$comment['user_id']]['role'] ?? '')
                                        <span class="badge badge-primary">{{$users[$comment['user_id']]['role']['name'] ?? ''}}</span>
                                    @else
                                        <span class="badge badge-default">免费会员</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="card-body border-fade">
                            {!! $comment['render_content'] !!}
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
            if (content.length < 6) {
                swal('Oops', '评论内容不能少于6个字', 'error');
                return;
            }
            $(this).attr('disabled', true);
            $(document).ajaxError(function (event, xhr) {
                $('#submit-comment').removeAttr('disabled');
                swal("失败", xhr.responseJSON.errors.content[0], "error");
            });
            $.post("{{$submitUrl}}", {
                'content': $('textarea[name="comment_content"]').val(),
                '_token': '{{csrf_token()}}'
            }, function (res) {
                $('#submit-comment').removeAttr('disabled');
                if (res.code !== 0) {
                    swal("失败", res.message, "error");
                } else {
                    $('textarea[name="comment_content"]').val('');
                    $('.comment-box').append(`
            <div class="card">
                <div class="card-body">
                    <div class="media bb-1 border-fade">
                        <img class="avatar avatar-lg" src="${res.data.user.avatar}">
                        <div class="media-body">
                            <p>
                                <strong class="fs-14">${res.data.user.nick_name}</strong>
                                <time class="float-right text-lighter">${res.data.created_at}</time>
                            </p>
                            <p>
${res.data.user.role}
                        </p>
                    </div>
                </div>
                <div class="card-body border-fade">
${res.data.content}
                        </div>
                    </div>
                </div>
`)
                }
            }, 'json');
        });
    </script>
@endsection