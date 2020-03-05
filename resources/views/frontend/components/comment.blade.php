<div class="row">
    <div class="col-12">
        @if($user)
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <textarea name="comment-content" placeholder="说点什么吧" class="form-control" rows="3"></textarea>
                    <small class="form-text text-muted">支持markdown语法</small>
                </div>
                <div class="form-group text-right">
                    <button type="button" class="btn btn-primary" id="submit-comment">评论</button>
                </div>
            </form>
        @else
            <div class="text-center py-2">
                请先 <a href="{{route('login')}}" class="login-auth" data-login="{{$user ? 1 : 0}}">登录</a>
            </div>
        @endif
    </div>
    <div class="col-sm-12 comment-box">
        @foreach($comments as $comment)
            <div class="row">
                <div class="col-12 comment-user py-2">
                    <div class="float-left">
                        <img src="{{$users[$comment['user_id']]['avatar'] ?? ''}}" width="50" height="50" class="br-50">
                    </div>
                    <div class="float-left ml-2">
                        <span class="nickname">{{$users[$comment['user_id']]['nick_name']}}</span>
                        @if($users[$comment['user_id']]['role'] ?? '')
                            <span class="badge badge-warning c-fff ml-1 v-tag">V</span>
                        @endif
                        <br>
                        <span class="date c-2">{{\Carbon\Carbon::parse($comment['created_at'])->diffForHumans()}}</span>
                    </div>
                </div>
                <div class="col-12 comment-content">
                    {!! $comment['render_content'] !!}
                </div>
            </div>
        @endforeach
    </div>
</div>

@section('js')
    <script>
        $('#submit-comment').click(function () {
            var content = $('textarea[name="comment-content"]').val();
            if (content.length < 6) {
                swal('Oops', '评论内容不能少于6个字', 'error');
                return;
            }
            $(document).ajaxError(function (event, xhr) {
                swal("失败", xhr.responseJSON.errors.content[0], "error");
            });
            $.post("{{$submitUrl}}", {
                'content': content,
                '_token': '{{csrf_token()}}'
            }, function (res) {
                if (res.code !== 0) {
                    swal("失败", res.message, "error");
                } else {
                    $('textarea[name="comment-content"]').val('');
                    var role = res.data.user.role.length > 0 ? '<span class="badge badge-warning c-fff ml-1 v-tag">V</span>' : '';
                    $('.comment-box').append(`
<div class="row">
                <div class="col-12 comment-user py-2">
                    <div class="float-left">
                        <img src="${res.data.user.avatar}" width="50" height="50" class="br-50">
                    </div>
                    <div class="float-left ml-2">
                        <span class="nickname">${res.data.user.nick_name}</span>${role}
                        <br>
                        <span class="date c-2">${res.data.created_at}</span>
                    </div>
                </div>
                <div class="col-12 comment-content">
                    ${res.data.content}
                        </div>
                    </div>

`)
                }
            }, 'json');
        });
    </script>
@endsection